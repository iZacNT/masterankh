<?php
/* @var View $this */
/* @var Payment $payment */

use frontend\components\View;
use frontend\models\Payment;

$this->h1 = 'Update payment';
?>

<?= $this->render('_form', [
    'model' => $payment,
]) ?>
