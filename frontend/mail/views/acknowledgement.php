<?php
/* @var View $this */
/* @var Job $job */

use frontend\models\Job;
use yii\helpers\Html;
use yii\web\View;
?>
Hello <?= Html::encode($job->user->fullName()) ?>,
We have notified you <?= $job->user->getPlan()->inform_limit ?> times today that your ping target URL / TEXT has changed, we have now deactivated the ping target:

Number/ID: <?= $job->id ?>&nbsp;
URL: <?= $job->url ?>&nbsp;
TEXT: <?= Html::encode($job->template) ?>&nbsp;

Your target url / text seems a bit unstable or changing a lot today, pls check your site / revise your target then login to www.genieping.com and start monitoring again by clicking Edit > put a tick back into the “Active” checkbox and click save.



Kind Regards

<?= Html::a('www.genieping.com', 'https://www.genieping.com', ['target' => '_blank']) ?>
