<?php
/* @var View $this */
/* @var User $user */

use frontend\components\View;
use frontend\models\User;

$this->h1 = 'Update user';
?>

<?= $this->render('_form', [
    'model' => $user,
]) ?>
