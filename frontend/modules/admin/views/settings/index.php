<?php
/* @var View $this */
/* @var User $user */

use frontend\models\User;
use frontend\components\View;

$this->h1 = 'Settings';
?>

<?= $this->render('/user/_form', [
    'model' => $user,
]) ?>
