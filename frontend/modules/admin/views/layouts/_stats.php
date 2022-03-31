<?php
/* @var View $this */
/* @var int $total */
/* @var int $active */
/* @var int $inactive */
/* @var int $notFound */
/* @var int $found */
/* @var int $timeout */
/* @var int $failed */
/* @var int $expired */

use frontend\assets\IcofontAsset;
use frontend\components\View;
use frontend\models\JobSearch;
use yii\helpers\Url;
?>

<style>
    .box-dashboard {
        height: 100px;
        box-shadow: 0 0 20px rgba(69,110,243,0.13) !important;
        text-align: center;
    }
    .text-title, .text-sub-title {
        font-size: 18px;
    }
    .container .row a {
        color: white;
    }
</style>

<div class="container" style="margin-top: 130px;">
    <div class="row">

        <a class="col-md-3" href="<?= Url::to(['', 'JobSearch[status]' => JobSearch::STATUS_FOUND]) ?>">
            <div class="shadow-lg p-3 mb-5 rounded box-dashboard">
                <p class="text-title">
                    <?= IcofontAsset::icon('check text-success') ?>
                    Text Monitor Success
                </p>
                <p class="text-sub-title"><?= $found ?></p>
            </div>
        </a>

        <a class="col-md-3" href="<?= Url::to(['', 'JobSearch[status]' => JobSearch::STATUS_NOT_FOUND]) ?>">
            <div class="shadow-lg p-3 mb-5 rounded box-dashboard">
                <p class="text-title">
                    <?= IcofontAsset::icon('close text-danger') ?>
                    Text Monitor Fails
                </p>
                <p class="text-sub-title"><?= $notFound ?></p>
            </div>
        </a>

        <a class="col-md-3" href="<?= Url::to(['', 'JobSearch[status]' => JobSearch::STATUS_TIMEOUT]) ?>">
            <div class="shadow-lg p-3 mb-5 rounded box-dashboard">
                <p class="text-title">
                    <?= IcofontAsset::icon('clock-time text-warning') ?>
                    Monitor Timeout
                </p>
                <p class="text-sub-title"><?= $timeout ?></p>
            </div>
        </a>

        <a class="col-md-3" href="<?= Url::to(['', 'JobSearch[status]' => JobSearch::STATUS_FAIL]) ?>">
            <div class="shadow-lg p-3 mb-5 rounded box-dashboard">
                <p class="text-title">
                    <?= IcofontAsset::icon('exclamation-circle text-danger') ?>
                    Target URL FAIL
                </p>
                <p class="text-sub-title"><?= $failed ?></p>
            </div>
        </a>

    </div>
    <div class="row">

        <a class="col-md-3" href="<?= Url::to(['']) ?>">
            <div class="shadow-lg p-3 mb-5 rounded box-dashboard">
                <p class="text-title">
                    <?= IcofontAsset::icon('bullseye') ?>
                    Target Totals
                </p>
                <p class="text-sub-title"><?= $total ?></p>
            </div>
        </a>

        <a class="col-md-3" href="<?= Url::to(['', 'JobSearch[active]' => 1]) ?>">
            <div class="shadow-lg p-3 mb-5 rounded box-dashboard">
                <p class="text-title">
                    <?= IcofontAsset::icon('check-circled text-success') ?>
                    Target Active
                </p>
                <p class="text-sub-title"><?= $active ?></p>
            </div>
        </a>

        <a class="col-md-3" href="<?= Url::to(['', 'JobSearch[active]' => 0]) ?>">
            <div class="shadow-lg p-3 mb-5 rounded box-dashboard">
                <p class="text-title">
                    <?= IcofontAsset::icon('exclamation-circle text-danger') ?>
                    Target Inactive
                </p>
                <p class="text-sub-title"><?= $inactive ?></p>
            </div>
        </a>

        <a class="col-md-3" href="<?= Url::to(['', 'JobSearch[status]' => JobSearch::STATUS_EXPIRED]) ?>">
            <div class="shadow-lg p-3 mb-5 rounded box-dashboard">
                <p class="text-title">
                    <?= IcofontAsset::icon('calendar text-danger') ?>
                    Target Expired
                </p>
                <p class="text-sub-title"><?= $expired ?></p>
            </div>
        </a>

    </div>
</div>
