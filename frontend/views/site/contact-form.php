<?php
/* @var View $this */
/* @var ContactForm $model */

use frontend\components\View;
use frontend\models\ContactForm;
use frontend\widgets\ActiveField;
use himiklab\yii2\recaptcha\ReCaptcha2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="text-center">
    <h4>CONTACT FORM</h4>
</div>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'theme-form',
    ],
    'fieldClass' => ActiveField::class,
]) ?>

<?= $form->field($model, 'name')->textInput(['class' => 'form-control']) ?>

<?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>

<?= $form->field($model, 'phone')->textInput(['class' => 'form-control']) ?>

<?= $form->field($model, 'website')->textInput(['class' => 'form-control']) ?>

<?= $form->field($model, 'message')->textarea(['class' => 'form-control']) ?>

<?= $form->field($model, 'send_copy_to_yourself')->checkbox() ?>

<?= $form->field($model, 'captcha')->widget(ReCaptcha2::class) ?>

<div class="form-group form-row mt-3 mb-0">

    <?= Html::submitButton('Send', [
        'class' => 'btn btn-primary btn-block',
    ]) ?>

</div>

<div class="form-group form-row mt-3 mb-0 text-center">

    <?= Html::a('Cancel', Url::home(), ['style' => 'margin:0 auto']) ?>

</div>

<?php ActiveForm::end() ?>
