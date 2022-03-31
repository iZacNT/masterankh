<?php
/* @var View $this */
/* @var ContactForm $model */

use frontend\components\View;
use frontend\models\ContactForm;
use himiklab\yii2\recaptcha\ReCaptcha2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'action' =>['site/contact-form'],
    'options' => [
        'class' => 'form-contact',
        'name' => 'name-form-contact',
    ],
    'fieldConfig' => [
        'template' => "{input}\n{hint}\n{error}",
    ],
]) ?>

<?= $form->field($model, 'name')->textInput(['class' => 'contact-form__text', 'placeholder' => $model->getAttributeLabel('name') . '*']) ?>

<?= $form->field($model, 'email')->textInput(['class' => 'contact-form__text', 'placeholder' => $model->getAttributeLabel('email') . '*']) ?>

<?= $form->field($model, 'phone')->textInput(['class' => 'contact-form__text', 'placeholder' => $model->getAttributeLabel('phone')]) ?>

<?= $form->field($model, 'website')->textInput(['class' => 'contact-form__text', 'placeholder' => $model->getAttributeLabel('website')]) ?>

<?= $form->field($model, 'message')->textarea(['class' => 'contact-form__text', 'placeholder' => $model->getAttributeLabel('message') . '*']) ?>

<?= $form->field($model, 'captcha')->widget(ReCaptcha2::class) ?>

<div class="contact-form__btn-wrapper">
    <?= Html::submitButton('SEND', [
        'class' => 'contact-form__send-btn',
    ]) ?>
</div>

<div class="contact-form__checkbox-wrapper">
    <?= $form->field($model, 'send_copy_to_yourself')->checkbox() ?>
</div>

<?php ActiveForm::end() ?>
