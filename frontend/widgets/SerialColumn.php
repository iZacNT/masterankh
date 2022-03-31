<?php

namespace frontend\widgets;

class SerialColumn extends \yii\grid\SerialColumn
{
    /**
     * {@inheritdoc}
     */
    public $contentOptions = [
        'class' => 'align-middle',
    ];
}
