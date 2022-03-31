<?php
/* @var View $this */
/* @var ContactForm $model */

use frontend\models\ContactForm;
use yii\helpers\Html;
use yii\web\View;
?>
You have received a new message.
<br><br>
Here are the details:
<br><br>
Name: <?= Html::encode($model->name) ?><br>
Email: <?= Html::encode($model->email) ?><br>
<?php if ($model->phone): ?>
    Phone: <?= Html::encode($model->phone) ?><br>
<?php endif ?>
<?php if ($model->website): ?>
    Website: <?= Html::encode($model->website) ?><br>
<?php endif ?>
Message:<br>
<?= nl2br(Html::encode($model->message)) ?><br>
