<?php
/* @var View $this */
/* @var User $model */

use frontend\components\View;
use frontend\models\User;
use frontend\widgets\ActiveField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin([
    'fieldClass' => ActiveField::class,
    'enableAjaxValidation' => true,
]) ?>

<?= $form->field($model, 'email')->textInput([
    'class' => 'form-control btn-square input-md disabled',
    'disabled' => true,
]) ?>

<?= $form->field($model, 'second_email')->textInput([
    'class' => 'form-control btn-square input-md' . ($model->getPlan()->isFree() ? ' disabled' : ''),
    'disabled' => $model->getPlan()->isFree(),
]) ?>

<?= $form->field($model, 'name')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'surname')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'gender')->dropDownList(User::$genders, [
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'mobile')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'phone')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'address_1')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'address_2')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'address_3')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'address_4')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'city')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'state')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'postal_code')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'country')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'company_name')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= $form->field($model, 'website_url')->textInput([
    'class' => 'form-control btn-square input-md',
]) ?>

<?= Html::submitButton('Save', [
    'class' => 'btn btn-success',
    'style' => 'width:150px; height:40px;',
]) ?>

<?php ActiveForm::end() ?>
