<?php
/* @var View $this */
/* @var Register $model */

use frontend\components\View;
use frontend\models\Register;
use frontend\widgets\ActiveField;
use himiklab\yii2\recaptcha\ReCaptcha2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<style>
    ul.social-auth li {
        display: flex;
        width: 100%;
        flex: 1;
    }

    ul.social-auth li a {
        flex: 1;
        width: 100%;
        display: flex;
        align-items: center;
        color: #fff;
        padding: 4px 10px;
        border: none;
        border-radius: 4px;
        margin: 5px 0;
        font-size: 17px;
        line-height: 20px;
        text-decoration: none;
    }

    ul.social-auth li a .auth-icon {
        margin: 0 15px 0 0;
    }

    a.link-social.link-google {
        background: #df4f3f;
    }

    a.link-social.link-facebook {
        background: #3a5897;
    }
    a.link-social:hover {
        opacity: 0.7;
    }
</style>
<div class="text-center">
    <h4>REGISTRATION</h4>
    <?php
    use yii\authclient\widgets\AuthChoice;
    ?>
    <?php $authAuthChoice = AuthChoice::begin([
        'baseAuthUrl' => ['site/auth'],
    ]); ?>
    <ul class="social-auth">
        <?php foreach ($authAuthChoice->getClients() as $client): ?>
            <li>
                <a class="link-social link-<?= $client->getName() ?>"
                   href="<?= $authAuthChoice->createClientUrl($client) ?>">
                    <span class="auth-icon <?=$client->getName()?>"></span>
                    Register with <?=ucfirst($client->getName())?></a>

            </li>
        <?php endforeach; ?>
    </ul>
    <?php AuthChoice::end(); ?>
    <div class="or">OR</div>
    <h6>Enter your data</h6>
</div>

<?php $form = ActiveForm::begin([
    'id' => 'registration-form',
    'options' => [
        'class' => 'theme-form',
    ],
    'fieldClass' => ActiveField::class,
    'enableAjaxValidation' => true,
]) ?>

<?= $form->field($model, 'name')->textInput(['class' => 'form-control']) ?>

<?= $form->field($model, 'surname')->textInput(['class' => 'form-control']) ?>

<?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>

<?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>

<?= $form->field($model, 'password_confirm')->passwordInput(['class' => 'form-control']) ?>

<?= $form->field($model, 'captcha')->widget(ReCaptcha2::class) ?>

<div class="form-group form-row mt-3 mb-0">

    <?= Html::submitButton('Register', [
        'class' => 'btn btn-primary btn-block',
    ]) ?>

</div>

<div class="form-group form-row mt-3 mb-0 text-center">

    <?= Html::a('Login', ['login'], ['style' => 'margin:0 auto']) ?>

</div>

<?php ActiveForm::end() ?>

<?php $this->registerJs(
    "$('#registration-form').on('afterValidateAttribute', function (e, attribute) {
        if (attribute.id == 'register-password') {
            $(this).yiiActiveForm('validateAttribute', 'register-password_confirm');
        }
    });",
    View::POS_READY,
    'password-validation'
) ?>
