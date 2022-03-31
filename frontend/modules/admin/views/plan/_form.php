<?php
/* @var View $this */
/* @var Plan $model */

use frontend\components\View;
use frontend\models\Plan;
use frontend\widgets\ActiveField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin([
    'fieldClass' => ActiveField::class,
    'enableAjaxValidation' => true,
]) ?>

<?= $form->field($model, 'name')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'price')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'notification_interval')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'inform_limit')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'target_limit')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>
<?= $form->field($model, 'subscription_duration')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= Html::submitButton('Save', [
    'class' => 'btn btn-success btn-lg',
]) ?>

<?php ActiveForm::end() ?>
