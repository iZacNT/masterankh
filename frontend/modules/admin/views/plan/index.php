<?php
/* @var View $this */
/* @var ActiveDataProvider $provider */

use frontend\assets\IcofontAsset;
use frontend\components\View;
use frontend\models\Plan;
use frontend\widgets\ActionColumn;
use frontend\widgets\GridView;
use frontend\widgets\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

$this->h1 = 'Plans';
?>

<?= GridView::widget([
    'dataProvider' => $provider,
    'tableOptions' => [
        'class' => 'table table-striped table-bordered text-center',
    ],
    'columns' => [
        [
            'class' => SerialColumn::class,
        ],
        'name',
        [
            'attribute' => 'price',
            'value' => function (Plan $plan) {
                return '£ ' . $plan->price;
            },
        ],
        'target_limit',
        [
            'label' => 'Subscription duration (Day)',
            'value' => function (Plan $plan) {
               return $plan->subscription_duration;
            },
        ],
        [
            'label' => 'Expire',
            'value' => function (Plan $plan) {
                $timestamp = $plan->expire() + time();
                return date('Y-m-d', $timestamp);
            },
        ],
        [
            'class' => ActionColumn::class,
            'header' => 'Actions',
            'template' => '{update}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a(
                        IcofontAsset::icon('pencil-alt-2', 1),
                        Url::to(['plan/update', 'id' => $model->id]),
                        ['title' => 'Update']
                    );
                },
            ]
        ],
    ],
]) ?>
