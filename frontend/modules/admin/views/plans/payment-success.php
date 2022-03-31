<?php
/* @var View $this */
/* @var float $delay */

use frontend\components\View;
use frontend\helpers\Html;
use yii\helpers\Url;

$this->h1 = 'Successful payment';
?>

<div class="alert alert-success alert-dismissable">
    You will be redirected to dashboard in <?= $delay ?> seconds.
</div>

<?= Html::redirect(
    Url::to(['/admin/main/dashboard']),
    $delay
) ?>
