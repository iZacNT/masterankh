<?php
/* @var View $this */
/* @var JobSearch $search */
/* @var ArrayDataProvider $provider */
/* @var bool $canCreate */
/* @var int $quantityPaid */

use frontend\assets\IcofontAsset;
use frontend\components\View;
use frontend\helpers\StringHelper;
use frontend\models\JobSearch;
use frontend\models\Job;
use frontend\modules\admin\assets\JobTableAsset;
use frontend\modules\admin\controllers\MainController;
use frontend\widgets\ActionColumn;
use frontend\widgets\GridView;
use frontend\widgets\SerialColumn;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

JobTableAsset::register($this);

$this->h1 = 'Monitoring';
$buttonClass = $canCreate ? 'btn btn-success' : 'btn btn-secondary';
$buttonUrl = $canCreate ? 'create' : '/admin/plans';
$flashPayment = Yii::$app->session->get(\frontend\models\Plan::SESSION_PAYMENT);
$expired = 0;
if ($flashPayment) {
    $expired = $flashPayment['expiredTime'];
}
?>
<script>
    var expired = <?=$expired ?: 0?>;
    <?php
        if ($flashPayment && $expired > time()):
    ?>
    setInterval(function () {
        var timeStamp = new Date().getTime();
        $('#second').text(+expired - Math.round(+timeStamp / 1000));

        if (timeStamp > expired) {
            window.location.reload();
        }
    }, 1000);
    <?php endif; ?>
</script>

<style type="text/css">
    th > a {
        color: rgba(255,255,255,0.85);
    }
    .buttons-right {
        float: right;
    }
    .quantityPaid {
        display: block;
        padding-top: 5px;
    }
    .btn-secondary, .btn-secondary:hover {
        color: #fff !important;
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }
    .item-ping {
        box-shadow: 0 0 20px rgb(69 110 243 / 13%) !important;
        margin: 0 -30px;
        padding: 15px;
    }

    .item-ping + .item-ping {
        margin-top: 20px;
    }
    .item-ping .label {
        font-weight: 700;
    }
    .flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .actions {
        margin-bottom: 5px;
    }
    .icon-update {
        margin-right: 10px;
    }
    .mobile-view {
        display: none;
    }
    @media only screen and (max-width: 767px) {
        .grid-view .summary, .grid-view #w1,  .grid-view table{
            display: none;
        }
        .mobile-view {
            display: block;
        }
        nav#w2 {
            margin-top: 20px;
        }
    }
</style>
<?php
if ($flashPayment && $expired > time()):
    ?>
    <div class="alert alert-success alert-dismissable">
        Payment has been successful, please wait a moment
        the system will automatically update your quantity paid.
        <div>Auto refresh page in <span id="second">7</span> seconds</div>
    </div>
<?php endif?>
<div class="row">
    <div class="col-md-12">
        <div class="buttons-right">
            <?= Html::a('Create', [$buttonUrl], ['class' => $buttonClass]) ?>
            <span class="quantityPaid">Quantity paid: <?= $quantityPaid?> </span>
            <hr>
        </div>
    </div>
</div>

<?php Pjax::begin([
    'options' => [
        'id' => 'pjax-table',
        'data-id' => $id = Yii::$app->session->getFlash(MainController::FLASH_JOB_SAVED),
    ],
]) ?>
<div class="mobile-view">
    <?php
    foreach ($provider->getModels() as $record) {
        ?>
        <div class="item-ping">

            <div class="item-column">
                <div class="flex">
                    <h4><?=$record->title?></h4>
                    <div class="actions">
                        <?=Html::a(
                            IcofontAsset::icon('pencil-alt-2', 1),
                            Url::to(['update', 'id' => $record->id]),
                            ['title' => 'Update', 'class' => 'icon-update' ]
                        )?>
                        <?= Html::a(IcofontAsset::icon('trash', 1),
                            Url::to(['delete', 'id' => $record->id]),
                            ['data-confirm' => 'Are you sure you want to "Delete" this ping target? You will not be refunded any payments.', 'title' => 'Delete']
                        )?>
                    </div>

                </div>
            </div>
            <a href="<?=$record->url?>" target="_blank"><?=$record->url?></a>
            <?php
            if ($record->id == $id) {
                echo IcofontAsset::icon('spinner icofont-spin');
            } elseif ($record->status !== Job::STATUS_FAIL) {
                echo IcofontAsset::icon('check-circled text-success');
            } else {
                echo IcofontAsset::icon('exclamation-circle text-danger');
            }
            ?>
            <div class="item-column">
                <span class="label">Text/Code to find: </span><?=$record->template?>
            </div>
            <div class="item-column">
                <span class="label">Monitor interval (seconds): </span>
                <?=$record->interval?>
            </div>
            <div class="item-column">
                <span class="label">Time of last failure: </span>
                <?=$record->last_error ? date('Y-m-d H:i:s', $record->last_error) : ''?>
            </div>
            <div class="item-column">
                <span class="label">Expiry: </span>
                <?=date('Y-m-d H:i:s', $record->getExpirationDate())?>
            </div>
            <div class="item-column">
                <span class="label">Ping Status: </span>
                <?php
                if ($record->id == $id) {
                    echo IcofontAsset::icon('spinner icofont-spin');
                } elseif ($record->isExpired()) {
                    echo Html::a(
                        IcofontAsset::icon('cart text-info'),
                        ['plans/index']
                    );
                } elseif ($record->status == Job::STATUS_TIMEOUT) {
                    echo IcofontAsset::icon('clock-time text-warning');
                } elseif ($record->status == Job::STATUS_FOUND) {
                    echo IcofontAsset::icon('check text-success');
                } else {
                    echo IcofontAsset::icon('close text-danger');
                }
                ?>
            </div>

        </div>
    <?php
    }
    ?>
</div>

<?= GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $search,
    'columns' => [
        [
            'class' => SerialColumn::class,
        ],
        'title',
        [
            'label' => 'Website address',
            'attribute' => 'url',
            'format' => 'raw',
            'value' => function (Job $job) {
                $icon = IcofontAsset::icon('external-link', 1);
                return StringHelper::shortener($job->url, 50) . ' ' . Html::a($icon, $job->url, ['target' => '_blank']);
            },
        ],
        [
            'label' => 'Address status',
            'format' => 'raw',
            'value' => function (Job $job) use ($id) {
                if ($job->id == $id) {
                    return IcofontAsset::icon('spinner icofont-spin');
                } elseif ($job->status !== Job::STATUS_FAIL) {
                    return IcofontAsset::icon('check-circled text-success');
                } else {
                    return IcofontAsset::icon('exclamation-circle text-danger');
                }
            },
        ],
        [
            'attribute' => 'template',
            'value' => function (Job $job) {
                return $job->template;
            },
        ],
        [
            'label' => 'Monitor interval (seconds)',
            'value' => function (Job $job) {
                return $job->interval;
            },
        ],
        [
            'label' => 'Time/date of last text failure',
            'value' => function (Job $job) {
                return $job->last_error ? date('Y-m-d H:i:s', $job->last_error) : '';
            },
        ],
        [
            'label' => 'Expiry',
            'value' => function (Job $job) {
                return date('Y-m-d H:i:s', $job->getExpirationDate());
            },
        ],
        [
            'attribute' => 'status',
            'filter' => JobSearch::$statuses,
            'format' => 'raw',
            'value' => function (Job $job) use ($id) {
                if ($job->id == $id) {
                    return IcofontAsset::icon('spinner icofont-spin');
                } elseif ($job->isExpired()) {
                    return Html::a(
                        IcofontAsset::icon('cart text-info'),
                        ['plans/index']
                    );
                } elseif ($job->status == Job::STATUS_TIMEOUT) {
                    return IcofontAsset::icon('clock-time text-warning');
                } elseif ($job->status == Job::STATUS_FOUND) {
                    return IcofontAsset::icon('check text-success');
                } else {
                    return IcofontAsset::icon('close text-danger');
                }
            },
        ],
        [
            'attribute' => 'active',
            'filter' => ['Inactive', 'Active'],
            'format' => 'raw',
            'value' => function (Job $job) {
                if ($job->active) {
                    return IcofontAsset::icon('check text-success');
                } else {
                    return IcofontAsset::icon('close text-danger');
                }
            },
        ],
        [
            'class' => ActionColumn::class,
            'header' => 'Actions',
            'template' => '{update} {delete}',
            'contentOptions' => ['class' => 'align-middle'],
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a(
                        IcofontAsset::icon('pencil-alt-2', 1),
                        Url::to(['update', 'id' => $model->id]),
                        ['title' => 'Update']
                    );
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a(
                        IcofontAsset::icon('trash', 1),
                        Url::to(['delete', 'id' => $model->id]),
                        ['data-confirm' => 'Are you sure you want to "Delete" this ping target? You will not be refunded any payments.', 'title' => 'Delete']
                    );
                },
            ],
        ],
    ],
]) ?>

<?php Pjax::end() ?>
