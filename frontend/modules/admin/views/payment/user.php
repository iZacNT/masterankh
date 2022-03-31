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
    'columns'      => [
        [
            'class' => SerialColumn::class,
        ],
        [
            'label'     => 'First name',
            'attribute' => 'user_id',
            'filter'    => false,
            'value'     => function (Payment $payment) {
                return $payment->user->name;
            },
        ],
        [
            'label'     => 'Last name',
            'attribute' => 'user_id',
            'filter'    => false,
            'value'     => function (Payment $payment) {
                return $payment->user->surname;
            },
        ],
        [
            'label'     => 'Plan',
            'attribute' => 'plan_id',
            'filter'    => false,
            'value'     => function (Payment $payment) {
                return $payment->plan->name;
            },
        ],
        [
            'label'     => 'Quantity',
            'attribute' => 'quantity',
            'filter'    => false,
        ],
        [
            'label'  => 'Start date',
            'filter' => false,
            'value'  => function (Payment $payment) {
                return $payment->start_date;
            },
        ],
        [
            'label'  => 'Expire',
            'filter' => false,
            'value'  => function (Payment $payment) {
                return $payment->end_date;
            },
        ],
        [
            'label'  => 'Status',
            'filter' => false,
            'value'  => function (Payment $payment) {
                return $payment->payment_status;
            },
        ],
        [
            'label'  => 'Actions',
            'filter' => false,
            'format' => 'raw',
            'value'  => function (Payment $payment) {
                return $payment->payment_status === Payment::COMPLETED ? '<a class="btn-cancel"
                 href="https://www.paypal.com/myaccount/autopay/connect/'. $payment->subscr_id .'/cancel">
                            <img src="https://www.paypalobjects.com/en_US/i/btn/btn_unsubscribe_LG.gif">
                        </a>' : '';
            },
        ],
    ],
]) ?>

<?php $this->registerJs(/* @lang JavaScript */ '
    $(".btn-cancel").on("click", function (e) {
       e.preventDefault(); 
       if (confirm("Are you sure you want to cancel your subscription?")) {
           window.location.href = e.currentTarget.href;
       }
       
    })
', View::POS_READY, 'btn-cancel') ?>
