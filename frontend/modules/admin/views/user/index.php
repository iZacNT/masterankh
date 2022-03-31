<?php
/* @var View $this */
/* @var UserSearch $search */
/* @var ActiveDataProvider $provider */

use frontend\assets\IcofontAsset;
use frontend\models\UserSearch;
use frontend\widgets\ActionColumn;
use frontend\widgets\GridView;
use frontend\widgets\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\components\View;

$this->h1 = 'Users';
?>
<?= GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $search,
    'columns' => [
        [
            'class' => SerialColumn::class,
        ],
        [
            'attribute' => 'name',
        ],
        [
            'attribute' => 'surname',
        ],
        [
            'attribute' => 'email',
        ],
        [
            'attribute' => 'second_email',
        ],
        [
            'class' => ActionColumn::class,
            'header' => 'Actions',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a(
                        IcofontAsset::icon('pencil-alt-2', 1),
                        Url::to(['user/update', 'id' => $model->id]),
                        ['title' => 'Update']
                    );
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a(
                        IcofontAsset::icon('trash', 1),
                        Url::to(['user/delete', 'id' => $model->id]),
                        ['data-confirm' => 'Are you sure you want to delete this user?', 'title' => 'Delete']
                    );
                },
            ],
        ],
    ],
]) ?>
