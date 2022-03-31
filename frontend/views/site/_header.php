<?php
// check auto deploy
/* @var View $this */

use frontend\components\View;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<header class="header__home">

    <!------------header background------------->
    <!-- background selection in javascript file -->
    <div class="header__background default-background">
        <picture>
            <source srcset="../../theme/images/genieping/Homepage-playstation-5-pre-order-Slide-one.webp" type="image/webp">
            <img src="../../theme/images/genieping/Homepage-playstation-5-pre-order-Slide-one.jpg" alt="">
        </picture>
    </div>
    <div class="header__background header__background_chrome-desktop-webm"></div>
    <div class="header__background header__background_other-desktop-mp4"></div>
    <div class="header__background header__background_mobile"></div>
    <!------------header background end------------->

    <div class="header__logo">
        <?= Html::a(
            Html::img('@web/theme/images/genieping/brand/logo/genieping-logo.svg', ['alt' => 'Home page']),
            Url::home()
        ) ?>
    </div>

    <div class="header__sign-in-btn">
        <div class="header__sign-in-svg">
            <svg class="feather feather-user" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </div>

        <?= Html::a('Sign In', Yii::$app->user->loginUrl, ['class' => 'header__sign-in-text']) ?>

    </div>
    <div class="container">
        <div class="header__home-top">
            <h1 class="header__home-title">
                Be FIRST to know when the next Wave of <br>PlayStation 5 or Xbox Series X consoles hit...
            </h1>
            <div class="header__home-subtitle">
                <div>Get a free trial, no credit cards required, </div>
                <div>and catch the latest console releases as they launch!</div>
                <div>Do you wish you could catch the latest console releases as they come out?</div>
            </div>
        </div>
        <div class="header__home-bottom home-bottom">

            <div class="home-bottom__reg-wrapper" style="margin:0 auto;">
                <?= Html::a(
                    'register',
                    ['/site/register'],
                    ['class' => 'home-bottom__register-btn', 'style' => 'display: block; color: black; text-align: center;']
                ) ?>
            </div>

        </div>
    </div>
</header>
