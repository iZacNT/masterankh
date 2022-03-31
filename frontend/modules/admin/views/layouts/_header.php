<?php
/* @var View $this */

use frontend\assets\IcofontAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\components\View;
?>

<style>
    .text-menu {
        color: white; font-size: 16px; margin-right: 25px; text-decoration: none;
    }
    .text-menu:hover {
        color: #4466f2; font-size: 16px; margin-right: 25px; text-decoration: none;
    }
    @media only screen and (max-width: 767px) {
        .page-main-header .main-header-right .nav-right>ul.nav-menus {
            display: none;
        }
        .page-main-header .main-header-right .nav-right>ul.nav-menus.open {
            display: block;
            position: absolute;
            top: 80px;
            left: 0;
            right: 0;
            width: 100%;
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }
        .main-header-right.row {
            position: relative;
        }

        .main-header-right .nav-right.col.p-0 {
            position: initial;
        }
        .li-nav-menu {
            flex: 1 1 100%;
        }
    }
    @media only screen and (max-width: 586px) {
        .toggle-fullscreen {
            padding: 15px !important;
        }
        .user-icon {
            padding: 0 !important;
        }
        a.Typeahead-input.text-menu {
            display: block;
            width: 50%;
            margin: 0;
            padding: 5px;
            text-align: left;
        }
    }
</style>

<div class="page-main-header" style="margin-left: 0; width: 100%;">
    <div class="main-header-right row">
        <div class="mobile-sidebar d-block">

            <?= Html::a(
                Html::img('@web/theme/images/genieping/brand/logo/genieping-logo.svg', ['height' => 50]),
                Url::home(),
                ['class' => 'text-menu']
            ) ?>

        </div>
        <div class="nav-right col p-0">
            <ul class="nav-menus">
                <li class="li-nav-menu">
                    <div class="form-inline search-form">
                        <a class="Typeahead-input text-menu" href="<?= Url::home() ?>">Home</a>
                        <a class="Typeahead-input text-menu" href="<?= Url::toRoute(['/admin/main/dashboard']) ?>">Dashboard</a>
                        <a class="Typeahead-input text-menu" href="<?= Url::toRoute(['/admin/settings']) ?>">Settings</a>
                        <a class="Typeahead-input text-menu" href="<?= Url::toRoute(['/admin/plans']) ?>">Upgrade Plans</a>
                        <a class="Typeahead-input text-menu" href="<?= Url::toRoute(['/admin/payment/user'])
                        ?>">Payments</a>
                        <?php if(Yii::$app->user->isAdmin()): ?>
                            <a class="Typeahead-input text-menu" href="<?= Url::toRoute(['/admin/user']) ?>">Users</a>
                            <a class="Typeahead-input text-menu" href="<?= Url::toRoute(['/admin/main']) ?>">Targets</a>
                            <a class="Typeahead-input text-menu" href="<?= Url::toRoute(['/admin/plan']) ?>">Plans</a>
                            <a class="Typeahead-input text-menu" href="<?= Url::toRoute(['/admin/payment']) ?>">Payments</a>
                        <?php endif ?>
                    </div>
                </li>
                <li class="toggle-fullscreen">
                    <a class="text-dark" href="#" onclick="javascript:toggleFullScreen()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg>
                    </a>
                </li>

                <li class="onhover-dropdown user-icon">
                    <div class="media align-items-center">

                        <?= IcofontAsset::icon('user', 'lg') ?>

                    </div>
                    <ul class="profile-dropdown onhover-show-div p-20">
                        <li>
                            <a href="<?= Url::toRoute(['/admin/settings']) ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>                                    Edit Profile
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::toRoute(['/site/logout']) ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>                                    Logout
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
            <div class="d-lg-none mobile-toggle pull-right">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list"
                     viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </div>
        </div>
    </div>
</div>
