<?php
/* @var View $this */
/* @var JobSearch $search */
/* @var ActiveDataProvider $provider */

use frontend\helpers\StringHelper;
use frontend\widgets\ActionColumn;
use frontend\widgets\GridView;
use frontend\assets\IcofontAsset;
use frontend\components\View;
use frontend\models\Job;
use frontend\models\JobSearch;
use frontend\modules\admin\assets\JobTableAsset;
use frontend\modules\admin\controllers\MainController;
use frontend\widgets\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

JobTableAsset::register($this);

$this->h1 = 'Targets';
?>

<style type="text/css">
    th > a {
        color: rgba(255,255,255,0.85);
    }
</style>

<?php Pjax::begin([
    'options' => [
        'id' => 'pjax-table',
        'data-id' => $id = Yii::$app->session->getFlash(MainController::FLASH_JOB_SAVED),
    ],
]) ?>

<?= GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $search,
    'columns' => [
        [
            'class' => SerialColumn::class,
        ],
        [
            'attribute' => 'user_name',
            'value' => 'user.name',
        ],
        [
            'label' => 'User email',
            'attribute' => 'user_second_email',
            'value' => 'user.second_email',
        ],
        [
            'label' => 'Name',
            'attribute' => 'title',
        ],
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
        'template',
        [
            'label' => 'Monitor interval (seconds)',
            'attribute' => 'interval',
            'filter' => false,
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
            'buttons' => [
                'update' => function ($url, Job $model, $key) {
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
                        ['data-confirm' => 'Are you sure you want to "Delete" this ping target?', 'title' => 'Delete']
                    );
                },
            ],
        ],
    ],
]) ?>

<?php Pjax::end() ?>
