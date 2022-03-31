<?php
/* @var View $this */
/* @var Job $job */

use frontend\models\Job;
use yii\helpers\Html;
use yii\web\View;
?>
Hello <?= Html::encode($job->user->fullName()) ?>,

Thank you for your interest in Genie Ping’s services and applications.

EXPIRES IN: Expired on <?= date('Y-m-d', ($payment = $job->user->getLastPayment()) ? $payment->date_create : time()) ?>&nbsp;
Number/ID: <?= $job->id ?>&nbsp;
URL: <?= $job->url ?>&nbsp;
TEXT: <?= Html::encode($job->template) ?>&nbsp;
STATUS: <?= $job->getStatusName() ?>&nbsp;

Genie Ping is not monitoring this target url / text. To renew your Ping target or buy more Pings, log in to your Genie Ping account www.genieping.com

If you have any questions, please send us an email at <?= Html::encode(Yii::$app->params['email']['help']) ?>.



Kind Regards

<?= Html::a('www.genieping.com', 'https://www.genieping.com', ['target' => '_blank']) ?>
