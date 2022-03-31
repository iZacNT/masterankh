<?php
/* @var View $this */
/* @var Payment $payment */

use frontend\models\Payment;
use yii\helpers\Html;
use yii\web\View;
?>
Thank you for your payment. We have attached your invoice. You can find your invoice below.

Invoice/ID: <?= $payment->id ?>&nbsp;
Invoice date: <?= date('d/m/Y', $payment->date_create) ?>&nbsp;
Amount paid: £<?= $totalPrice = $payment->totalPrice() ?>.00

Summary

<?= Html::encode($payment->plan->fullName()) ?>: £<?= $totalPrice ?>.00
Total: £<?= $totalPrice ?>.00

If you have any questions, please send us an email to <?= Html::encode(Yii::$app->params['email']['help']) ?>.



Kind Regards

<?= Html::a('www.genieping.com', 'https://www.genieping.com', ['target' => '_blank']) ?>
