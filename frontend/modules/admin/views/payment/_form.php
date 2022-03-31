<?php
/* @var View $this */
/* @var Payment $model */

use frontend\components\View;
use frontend\models\Payment;
use frontend\models\Plan;
use frontend\widgets\ActiveField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin([
    'fieldClass' => ActiveField::class,
    'enableAjaxValidation' => true,
]) ?>

<?= $form->field($model, 'plan_id')->dropDownList(Plan::getList([Plan::FREE]), [
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'quantity')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'valid_to')->widget(\yii\jui\DatePicker::className(), [
    'options' => ['class' => 'form-control'],
    'dateFormat' => 'yyyy-MM-dd',
])?>

<?= $form->field($model, 'payment_status')->dropDownList(
    [
        '' => '',
        'Completed' => 'Completed',
        'Canceled' => 'Canceled',
        'Subscribed' => 'Subscribed',
    ],
    [
    'class' => 'form-control btn-square input-md',
])?>

<?= Html::submitButton('Save', [
    'class' => 'btn btn-success btn-lg',
]) ?>

<?php ActiveForm::end() ?>
