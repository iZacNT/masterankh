<?php

namespace frontend\modules\admin\controllers;

use app\modules\admin\repositories\PaymentRepository;
use app\modules\admin\services\PaymentService;
use frontend\helpers\EmailHelper;
use frontend\models\Job;
use frontend\models\JobSearch;
use frontend\modules\admin\components\Controller;
use http\Url;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class MainController extends Controller
{
    const FLASH_JOB_SAVED = 'job_saved';

    public $paymentRepository;
    public $paymentService;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['dashboard', 'update', 'delete', 'check'],
                        'roles' => ['user'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'matchCallback' => function () {
                            return Yii::$app->user->identity->canCreateNewJob();
                        },
                    ],
                    [
                        'allow' => false,
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    if ($action->id == 'index') {
                        return $this->redirect(['dashboard']);
                    }
                    throw new ForbiddenHttpException;
                },
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->paymentService->addFreePlanIfLoggedNewUser();
        if (stripos(Yii::$app->request->referrer,'payment-success') || stripos(Yii::$app->request->referrer,'paypal')) {
            $this->paymentService->checkPaymentFromSession();
        } else {
            $this->paymentService->clearSessionData();
        }
        return parent::beforeAction($action);
    }

    public function __construct($id, $module, PaymentRepository $paymentRepository, PaymentService $paymentService, $config = [])
    {
        $this->paymentRepository = $paymentRepository;
        $this->paymentService = $paymentService;
        parent::__construct($id, $module, $config);
    }

    /**
     * User's dashboard.
     * @return string
     */
    public function actionDashboard()
    {
        $this->layout = '@frontend/modules/admin/views/layouts/index';

        $search = new JobSearch;
        $provider = $search->search(Yii::$app->request->queryParams);
        $provider->query->byUser(Yii::$app->user->id);
        $quantityPaid = $this->paymentRepository->getQuantityByUserId(Yii::$app->user->id);
        return $this->render('dashboard', [
            'search' => $search,
            'provider' => $provider,
            'canCreate' => Yii::$app->user->identity->canCreateNewJob(),
            'quantityPaid' => $quantityPaid ?: 0,
        ]);
    }

    /**
     * Jobs list.
     * @return string
     */
    public function actionIndex()
    {
        $search = new JobSearch;
        $provider = $search->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'search' => $search,
            'provider' => $provider,
        ]);
    }

    /**
     * Create new job.
     * @return array|string|Response
     */
    public function actionCreate()
    {
        $canCreate = Yii::$app->user->identity->canCreateNewJob();
        $paymentAvailable = Yii::$app->user->identity->getPaymentAvailable();
        if (!$canCreate || !$paymentAvailable) {
            return $this->redirect('/admin/plans');
        }
        $job = new Job;
        $load = $job->load($_POST);
        $job->payment_id = $paymentAvailable->id;
        // AJAX validation
        if ($load && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($job);
        }
        // Saving data
        if ($load && $job->save()) {
            Yii::$app->session->setFlash(self::FLASH_JOB_SAVED, $job->id);
            if (empty($_GET['to'])) {
                return $this->redirect(['dashboard']);
            } else {
                EmailHelper::inform($job);
                return $this->redirect(['update', 'id' => $job->id]);
            }
        }

        return $this->render('create', [
            'job' => $job,
        ]);
    }

    /**
     * Update job.
     * @param int $id - job ID
     * @return array|string|Response
     */
    public function actionUpdate($id)
    {
        $job = $this->getModel(Job::class, $id); /* @var Job $job */
        if ($job->isExpired()) {
            return $this->render('update', [
                'job' => $job,
            ]);
        }
        $load = $job->load($_POST);
        // AJAX validation
        if ($load && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($job);
        }

        // Saving data
        if ($load && $job->save()) {
            Yii::$app->session->setFlash(self::FLASH_JOB_SAVED, $job->id);
            if (empty($_GET['to'])) {
                return $this->redirect(['dashboard']);
            } else {
                EmailHelper::inform($job);
                return $this->redirect(['update', 'id' => $job->id]);
            }
        }

        return $this->render('update', [
            'job' => $job,
        ]);
    }

    /**
     * Delete job.
     * @param int $id - job ID
     * @return Response
     */
    public function actionDelete($id)
    {
        $job = $this->getModel(Job::class, $id); /* @var Job $job */
        $job->delete();
        return $this->redirect(['dashboard']);
    }

    /**
     * Check target.
     * @param int $id - job ID
     * @return void
     */
    public function actionCheck($id)
    {
        ignore_user_abort(true);

        $job = $this->getModel(Job::class, $id); /* @var Job $job */

        $ch = curl_init($job->url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0');
        $content = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $status = $job->checkTarget($content, $code);
        $job->setStatus($status);
        $job->save();
    }
}
