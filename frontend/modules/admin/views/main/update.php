<?php
/* @var View $this */
/* @var Job $job */

use frontend\assets\IcofontAsset;
use frontend\components\View;
use frontend\models\Job;
use frontend\modules\admin\assets\JobFormAsset;
use frontend\modules\admin\controllers\MainController;
use yii\widgets\Pjax;

JobFormAsset::register($this);

$this->h1 = 'Update target';
?>

<?php Pjax::begin([
    'options' => [
        'id' => 'pjax-alert',
        'data-id' => $flash = Yii::$app->session->getFlash(MainController::FLASH_JOB_SAVED),
    ],
]) ?>

<?php if ($flash): ?>
    <?= IcofontAsset::icon('spinner icofont-spin', 2) ?>
    <span class="lead">checking</span>
<?php else: ?>
    <?= $this->render('_alert', [
        'job' => $job,
    ]) ?>
<?php endif ?>

<?= $this->render('_form', [
    'model' => $job,
    'flash' => $flash,
]) ?>

<?php Pjax::end() ?>
