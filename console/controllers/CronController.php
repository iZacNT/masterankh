<?php

namespace console\controllers;

use frontend\helpers\EmailHelper;
use frontend\models\Job;
use RollingCurl\Request;
use RollingCurl\RollingCurl;
use yii\console\Controller;
use yii\console\ExitCode;

class CronController extends Controller
{
    /**
     * Check a batch of jobs.
     * Run every minute.
     * @return int
     */
    public function actionJob()
    {
        $start = microtime(true);
        for ($i = 0; $i < 6; $i++) {
            $passed = microtime(true) - $start;
            if (50 < $passed) {
                return ExitCode::OK;
            }
            $jobs = $this->getJobs(10);
            $this->checkJobs($jobs);
        }
        return ExitCode::OK;
    }

    /**
     * Reset column "inform_today".
     * Run at 0:00 every day.
     * @return int
     */
    public function actionResetinform()
    {
        Job::updateAll(['inform_today' => 0]);
        return ExitCode::OK;
    }

    /**
     * Get a batch of Jobs for further check.
     * @param int $limit
     * @return Job[]
     */
    private function getJobs(int $limit): array
    {
        return Job::find()
            ->needToCheck()
            ->orderBy('last_check ASC')
            ->limit($limit)
            ->all();
    }

    /**
     * Check list of jobs.
     * @param Job[] $jobs
     * @return void
     */
    private function checkJobs(array $jobs)
    {
        $rollingCurl = (new RollingCurl)
            ->setSimultaneousLimit(5)
            ->setCallback(function(Request $request) use ($jobs) {

                $headers = $request->getHeaders();
                $responseInfo = $request->getResponseInfo();
                $httpCode = $responseInfo['http_code'];
                $content = $request->getResponseText();

                foreach ($jobs as $job) {
                    if ($job->id == $headers['id']) break;
                }

                $status = $job->checkTarget($content, $httpCode);
                $statusChanged = $job->setStatus($status);
                if ($statusChanged && $job->allowInform()) {
                    $email = EmailHelper::inform($job);
                    if ($email && $job->status != Job::STATUS_FAIL) { // If email was sent and status not "fail"
                        $job->incrementInform();
                    }
                }
                $job->save();
            });

        foreach ($jobs as $job) {
            $job->setScenario(Job::SCENARIO_CHECK);

            if ($job->isExpired()) {

                if (EmailHelper::expiry($job)) {
                    $job->active = 0;
                    $job->save();
                }

            } elseif (!$job->isExpired() &&  $job->active == 0) {
                $job->active = 1;
                $job->save();
            } elseif ($job->isInformExceed()) {

                if (EmailHelper::acknowledgement($job)) {
                    $job->active = 0;
                    $job->save();
                }

            } else {

                $rollingCurl->get($job->url, ['id' => $job->id], [
                    CURLOPT_TIMEOUT => Job::CHECK_TIMEOUT,
                ]);

            }

        }
        $rollingCurl->execute();
    }
}
