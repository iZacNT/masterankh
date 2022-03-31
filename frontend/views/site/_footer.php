<?php
/* @var View $this */

use frontend\components\View;
use frontend\models\ContactForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<footer class="footer">
    <div class="container">
        <div class="footer__content">
            <div class="footer__contact-form contact-form" style="width: 100%;">
                <h2 class="contact-form__title">Contact Form</h2>
                <div class="contact-form__body">

                    <?= $this->render('_contact-form', [
                        'model' => new ContactForm,
                    ]) ?>

                </div>
            </div>
            <div class="footer__contact-info contact-info">
                <div class="contact-info__item"><img src="../../theme/images/genieping/Footer-Symbol-Time.svg" alt="">
                    <div class="contact-info__title">Working Hours</div>
                    <div class="contact-info__text">Monday-Friday: 9:00-18:00 UTC<br>Saturday, Sunday: 9:00-18:00 UTC</div>
                </div>
                <div class="contact-info__item"><img src="../../theme/images/genieping/Footer-Symbol-Phone.svg" alt="">
                    <div class="contact-info__title">Phone</div>
                    <div class="contact-info__text"><a href="tel:03301221237">Tel: 0330 122 1237</a></div>
                </div>
                <div class="contact-info__item"><img src="../../theme/images/genieping/Footer-Symbol-Map.svg" alt="">
                    <div class="contact-info__title">Address</div>
                    <div class="contact-info__text">7 Bell Yard, London,<br>WC2A 2JR</div>
                </div>
                <div class="contact-info__item"><img src="../../theme/images/genieping/Footer-Symbol-Email.svg" alt="">
                    <div class="contact-info__title">E-mail</div>
                    <div class="contact-info__text"><a href="mailto:info@genieping.com">info@genieping.com</a></div>
                </div>
            </div>
        </div>
        <div class="footer__content">

            <nav>
                <ul class="footer__list">
                    <li class="footer__list-item">
                        <?= Html::a('HOME', Url::home()) ?>
                    </li>
                    <li class="footer__list-item">
                        <?= Html::a('TERMS AND CONDITIONS', ['/site/terms-and-conditions']) ?>
                    </li>
                    <li class="footer__list-item">
                        <?= Html::a('PRIVACY POLICY', ['/site/privacy-policy']) ?>
                    </li>
                </ul>
            </nav>

        </div>
        <div class="footer__content">

            <?= Html::a(
                Html::img('@web/theme/images/genieping/brand/logo/genieping-logo.svg'),
                Url::home(),
                ['class' => 'footer__logo']
            ) ?>

            <div class="footer__copyright">
                <div>
                    <?= date('2016 - Y') ?>
                    © www.genieping.com
                </div>
            </div>
            <ul class="footer__social-list">
                <li class="footer__social-item">
                    <a href="#"><img src="../../theme/images/genieping/Footer-Social-Button-Twitter.svg"></a>
                </li>
                <li class="footer__social-item">
                    <a href="#"><img src="../../theme/images/genieping/Footer-Social-Button-Facebook.svg"></a>
                </li>
                <li class="footer__social-item">
                    <a href="#"><img src="../../theme/images/genieping/Footer-Social-Button-Google.svg"></a>
                </li>
                <li class="footer__social-item">
                    <a href="#"><img src="../../theme/images/genieping/Footer-Social-Button-Pinterest.svg"></a>
                </li>
                <li class="footer__social-item">
                    <a href="#"><img src="../../theme/images/genieping/Footer-Social-Button-In.svg"></a>
                </li>
            </ul>
        </div>
    </div>
</footer>
