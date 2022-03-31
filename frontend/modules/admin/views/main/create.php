<?php
/* @var View $this */
/* @var Job $job */

use frontend\components\View;
use frontend\models\Job;
use frontend\modules\admin\assets\JobFormAsset;
use frontend\modules\admin\controllers\MainController;

JobFormAsset::register($this);

$this->h1 = 'Create target';
?>

<?= $this->render('_form', [
    'model' => $job,
    'flash' => Yii::$app->session->getFlash(MainController::FLASH_JOB_SAVED)
]) ?>
