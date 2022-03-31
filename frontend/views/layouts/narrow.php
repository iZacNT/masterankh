<?php
/* @var View $this */
/* @var string $content */

use frontend\components\View;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="page-wrapper">
    <div class="auth-bg">
        <div class="authentication-box">
            <div class="text-center">

                <?= Html::a(
                    Html::img('@web/theme/images/genieping/brand/logo/genieping-logo.svg', ['height' => 100]),
                    Url::home()
                ) ?>

            </div>
            <div class="card mt-4">
                <div class="card-body">

                    <?= $content ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent() ?>
