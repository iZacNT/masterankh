<?php
/* @var View $this */
/* @var string $content */

use frontend\components\View;
use yii\helpers\Html;
?>

<?php $this->beginContent('@frontend/modules/admin/views/layouts/main.php') ?>

<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col">
                <div class="page-header-left">
                    <h1>
                        <?= Html::encode($this->h1) ?>
                    </h1>
                </div>
            </div>
            <div class="col">

            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    <?= $content ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent() ?>
