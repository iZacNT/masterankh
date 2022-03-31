<?php
/* @var View $this */
/* @var User $user */
/* @var string $link */

use frontend\models\User;
use yii\helpers\Html;
use yii\web\View;
?>
To confirm email please click: <?= Html::a('Confirm', $link, ['target' => '_blank']) ?>&nbsp;
