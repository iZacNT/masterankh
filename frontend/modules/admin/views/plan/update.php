<?php
/* @var View $this */
/* @var Plan $plan */

use frontend\components\View;
use frontend\models\Plan;

$this->h1 = 'Update plan';
?>

<?= $this->render('_form', [
    'model' => $plan,
]) ?>
