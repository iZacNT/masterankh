<?php
/* @var View $this */

/* @var Login $login */

use frontend\components\View;
use frontend\models\Login;
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
    <h4>LOGIN</h4>
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
                    Login with <?=ucfirst($client->getName())?></a>

            </li>
        <?php endforeach; ?>
    </ul>
    <?php AuthChoice::end(); ?>
    <div class="or">OR</div>
    <h6>Enter your Username and Password</h6>
</div>

<?php $form = ActiveForm::begin([
    'options'    => [
        'class' => 'theme-form',
    ],
    'fieldClass' => ActiveField::class,
]) ?>

<?= $form->field($login, 'email')->textInput(['class' => 'form-control']) ?>

<?= $form->field($login, 'password')->passwordInput(['class' => 'form-control']) ?>

<?= $form->field($login, 'remember_me')->checkbox() ?>

<?= $form->field($login, 'captcha')->widget(ReCaptcha2::class) ?>

<div class="form-group form-row mt-3 mb-0">

    <?= Html::submitButton('Login', [
        'class' => 'btn btn-primary btn-block',
    ]) ?>

</div>

<div class="form-group form-row mt-3 mb-0 text-center">

    <?= Html::a('Register', ['register'], ['style' => 'margin:0 auto']) ?>

</div>

<div style="color:#999;margin:1em 0">
    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
</div>

<?php ActiveForm::end() ?>
