<?php
/* @var View $this */
/* @var Plan $plan */
/* @var string $emailReadType */
/* @var bool $urlStatusCode */
/* @var bool $sendingCondition */
/* @var int $priority */
/* @var string $payment */
/* @var array $paymentParams */

use frontend\models\Plan;
use yii\helpers\Html;
use frontend\components\View;
?>
<div class="pricing-block card text-center">
    <svg x="0" y="0" viewBox="0 0 360 180" style="background-color: #4466f2; border-radius: 0;">

        <!--g>
            <path d="M0.732,193.75c0,0,29.706,28.572,43.736-4.512c12.976-30.599,37.005-27.589,44.983-7.061 c8.09,20.815,22.83,41.034,48.324,27.781c21.875-11.372,46.499,4.066,49.155,5.591c6.242,3.586,28.729,7.626,38.246-14.243 s27.202-37.185,46.917-8.488c19.715,28.693,38.687,13.116,46.502,4.832c7.817-8.282,27.386-15.906,41.405,6.294V0H0.48 L0.732,193.75z"></path>
        </g-->

        <?php if ($plan->price < 10): // 1 digit ?>
            <text transform="matrix(1 0 0 1 100 116)" fill="#fff" font-size="78.4489">£<?= $plan->price ?></text>
            <text transform="matrix(0.9566 0 0 1 185 83)" fill="#fff" font-size="29.0829">.00</text>
            <text transform="matrix(1 0 0 1 220 115)" fill="#fff" font-size="15.4128">/Month</text>
        <?php elseif ($plan->price < 100): // 2 digits ?>
            <text transform="matrix(1 0 0 1 69 116)" fill="#fff" font-size="78.4489">$<?= $plan->price ?></text>
            <text transform="matrix(0.9566 0 0 1 200 83)" fill="#fff" font-size="29.0829">.00</text>
            <text transform="matrix(1 0 0 1 233 115)" fill="#fff" font-size="15.4128">/Month</text>
        <?php else: // 3+ digits ?>
            <text transform="matrix(1 0 0 1 60 116)" fill="#fff" font-size="78.4489" class="total_price">$<?= $plan->price ?></text>
            <text transform="matrix(0.9566 0 0 1 235 83)" fill="#fff" font-size="29.0829">.00</text>
            <text transform="matrix(1 0 0 1 270 115)" fill="#fff" font-size="15.4128">/Month</text>
        <?php endif ?>

    </svg>
    <div class="pricing-inner">
        <h3 class="font-primary">
            <?= Html::encode($plan->name) ?>
        </h3>
        <ul class="pricing-inner text-left">
            <li class="padding-top-1">
                Notification interval
                <b><?= Html::encode($plan->notification_interval) ?> minutes</b>
            </li>
            <li class="padding-top-1">
                Emails/day/account
                <b>Up to <?= $plan->inform_limit ?></b>
            </li>
            <li class="padding-top-1">
                Email read type
                <b><?= Html::encode($emailReadType) ?></b>
            </li>
            <li class="padding-top-1">
                Email URL STATUS Code
                <b><?= $urlStatusCode ? 'Yes' : 'No' ?></b>
            </li>
            <li class="padding-top-1">
                Conditions for Sending, adjustable
                <b><?= $sendingCondition ? 'Yes' : 'No' ?></b>
            </li>
            <li class="padding-top-1">
                Email and Check Priority
                <b><?= $priority ?></b>
            </li>
            <li class="padding-top-1">
                Ping Targets
                <b class="target_limit" data-limit="<?= $plan->target_limit?>"><?= $plan->target_limit ?></b>
            </li>
            <li class="padding-top-1">
                Expiry date (after the initial setup)
                <b><?= date('Y-m-d', time() + $plan->expire()) ?></b>
            </li>
            <li class="padding-top-1">
                <?= Html::encode($payment) ?>
            </li>
        </ul>

        <?= $this->render('_form', [
            'plan' => $plan,
            'paymentParams' => $paymentParams,
        ]) ?>

    </div>
</div>
