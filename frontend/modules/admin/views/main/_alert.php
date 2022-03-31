<?php
/* @var View $this */
/* @var Job $job */

use frontend\components\View;
use frontend\models\Job;
use yii\helpers\Html;
?>

<?php if ($job->isExpired()): ?>
    <div class="alert alert-danger alert-dismissable">
        Target is expired
    </div>
<?php elseif ($job->status == Job::STATUS_NOT_FOUND || $job->status == Job::STATUS_FAIL): ?>
    <div class="alert alert-danger alert-dismissable">
        Text Read status was 'Failed'. We couldn't find the Text / URL of the web page you are monitoring for your Target.
        <?= Html::a('Read more here', ['/site/userguide'], ['target' => '_blank']) ?>
    </div>
<?php elseif ($job->status == Job::STATUS_FOUND): ?>
    <div class="alert alert-success alert-dismissable">
        Text Read status was 'Successful'. We found the Text / URL of the web page you are monitoring for your Target. Read more here.
        <?= Html::a('Read more here', ['/site/userguide'], ['target' => '_blank']) ?>
    </div>
<?php elseif ($job->status == Job::STATUS_TIMEOUT): ?>
    <div class="alert alert-warning alert-dismissable">
        Text Read status was 'Failed with Time Out'. We had to skip because we couldn't find the Text / URL of the web page you are monitoring for within the first <?= Job::CHECK_TIMEOUT ?> seconds. Read more here.
        <?= Html::a('Read more here', ['/site/userguide'], ['target' => '_blank']) ?>
    </div>
<?php endif ?>
