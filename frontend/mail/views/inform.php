<?php
/* @var View $this */
/* @var Job $job */

use frontend\models\Job;
use yii\helpers\Html;
use yii\web\View;
?>
Hello <?= Html::encode($job->user->fullName()) ?>,
<br><br>
A change has been detected since our last scan:
<br><br>
Number/ID: <?= $job->id ?>&nbsp;<br>
Group Name: <?= Html::encode($job->title) ?><br>
URL: <?= Html::encode($job->url) ?>&nbsp;<br>
TEXT: <?= Html::encode($job->template) ?>&nbsp;<br>
STATUS URL: <?= $job->status == Job::STATUS_FAIL ? '404' : '200 (Good)' ?><br>
STATUS TEXT: <?= $job->getStatusName() ?><br><br>

More info:<br>
The text / URL of the web page you are monitoring for your Genie Ping target could not be found. If you want to edit your text, revise, deactivate or add new targets, please log into your Genie Ping account. www.genieping.com <br><br><br><br>

Kind Regards,<br><br>

www.genieping.com
