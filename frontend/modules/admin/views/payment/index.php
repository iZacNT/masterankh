<?php
/* @var View $this */
/* @var PaymentSearch $search */
/* @var ActiveDataProvider $provider */

use frontend\assets\IcofontAsset;
use frontend\components\View;
use frontend\models\Payment;
use frontend\models\PaymentSearch;
use frontend\widgets\ActionColumn;
use frontend\widgets\GridView;
use frontend\widgets\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

$this->h1 = 'Payments';
?>

<?= GridView::widget([
    'dataProvider' => $provider,
    #'filterModel' => $search,
    'tableOptions' => [
        'class' => 'table table-striped table-bordered text-center',
    ],
    'columns' => [
        [
            'class' => SerialColumn::class,
        ],
        [
            'label' => 'First name',
            'attribute' => 'user_id',
            'filter' => false,
            'value' => function (Payment $payment) {
                return $payment->user->name;
            },
        ],
        [
            'label' => 'Last name',
            'attribute' => 'user_id',
            'filter' => false,
            'value' => function (Payment $payment) {
                return $payment->user->surname;
            },
        ],
        [
            'label' => 'Plan',
            'attribute' => 'plan_id',
            'filter' => false,
            'value' => function (Payment $payment) {
                return $payment->plan->name;
            },
        ],
        [
            'label' => 'Quantity',
            'attribute' => 'quantity',
            'filter' => false,
        ],
        [
            'label' => 'Start date',
            'filter' => false,
            'value' => function (Payment $payment) {
                return $payment->start_date;
            },
        ],
        [
            'label' => 'Expire',
            'filter' => false,
            'value' => function (Payment $payment) {
                return $payment->end_date;
            },
        ],
        [
            'label' => 'status',
            'filter' => false,
            'value' => function (Payment $payment) {
                return $payment->payment_status;
            },
        ],
        [
            'class' => ActionColumn::class,
            'header' => 'Actions',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a(
                        IcofontAsset::icon('pencil-alt-2', 1),
                        Url::to(['payment/update', 'id' => $model->id]),
                        ['title' => 'Update']
                    );
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a(
                        IcofontAsset::icon('trash', 1),
                        Url::to(['payment/delete', 'id' => $model->id]),
                        ['data-confirm' => 'Are you sure you want to delete this payment?', 'title' => 'Delete']
                    );
                },
            ],
        ],
    ],
]) ?>
