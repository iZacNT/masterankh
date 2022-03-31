<?php
/* @var View $this */
/* @var array $paymentParams */

use frontend\models\Plan;
use frontend\components\View;

$this->h1 = 'Plans';
?>

<div class="card-body row pricing-card-design-2 pricing-content">
    <div class="col-md-4">

        <?= $this->render('_price-block', [
            'plan' => Plan::getById(Plan::FREE),
            'emailReadType' => 'FAIL, TIMEOUT, SUCCESS',
            'urlStatusCode' => true,
            'sendingCondition' => false,
            'priority' => 3,
            'payment' => 'Free 1 per account in life of account',
            'paymentParams' => [],
        ]); ?>

    </div>
    <div class="col-md-4">

        <?= $this->render('_price-block', [
            'plan' => Plan::getById(Plan::BUSINESS),
            'emailReadType' => 'FAIL, TIMEOUT, SUCCESS',
            'urlStatusCode' => true,
            'sendingCondition' => false,
            'priority' => 2,
            'payment' => 'Paypal Payment Form',
            'paymentParams' => $paymentParams,
        ]); ?>

    </div>
    <div class="col-md-4">

        <?= $this->render('_price-block', [
            'plan' => Plan::getById(Plan::ENTERPRISE),
            'emailReadType' => 'FAIL, TIMEOUT, SUCCESS',
            'urlStatusCode' => true,
            'sendingCondition' => false,
            'priority' => 1,
            'payment' => 'Paypal Payment Form',
            'paymentParams' => $paymentParams,
        ]); ?>

    </div>
</div>
