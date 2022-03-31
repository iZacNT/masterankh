<?php

namespace frontend\widgets;

class DataColumn extends \yii\grid\DataColumn
{
    /**
     * {@inheritdoc}
     */
    public $contentOptions = [
        'class' => 'align-middle',
    ];

    /**
     * {@inheritdoc}
     */
    public $filterInputOptions = [
        'class' => 'form-control',
        'id' => null,
        'placeholder' => 'Enter text...',
        'prompt' => 'Filter select...',
    ];
}
