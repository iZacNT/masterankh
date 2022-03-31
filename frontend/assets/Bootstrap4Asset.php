<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class Bootstrap4Asset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $css = [
        'css/bootstrap.min.css',
    ];

    /**
     * {@inheritdoc}
     */
    public $js = [
        'js/bootstrap.min.js',
    ];

    /**
     * {@inheritdoc}
     */
    public $sourcePath = '@npm/bootstrap/dist';
}
