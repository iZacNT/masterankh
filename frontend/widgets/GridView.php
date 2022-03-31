<?php

namespace frontend\widgets;

class GridView extends \yii\grid\GridView
{
    /**
     * {@inheritdoc}
     */
    public $layout = "{summary}\n{pager}\n{items}\n{pager}";

    /**
     * {@inheritdoc}
     */
    public $pager = [
        'firstPageLabel' => false,
        'lastPageLabel' => false,
    ];

    /**
     * {@inheritdoc}
     */
    public $tableOptions = [
        'class' => 'table table-striped table-bordered text-center',
    ];

    /**
     * {@inheritdoc}
     */
    public $dataColumnClass = DataColumn::class;
}
