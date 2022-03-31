<?php

namespace frontend\assets;

use yii\bootstrap\BootstrapPluginAsset;
use yii\jui\JuiAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use yii\web\View;
use yii\web\YiiAsset;

class AppAsset extends AssetBundle
{
    public $jsOptions = ['position' => View::POS_HEAD];

    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
        'css/style.css',
    ];

    public $js = [
        'js/head.js',
        ['js/main.js', 'position' => View::POS_END],
    ];

    public $depends = [
        YiiAsset::class,
        JuiAsset::class,
        JqueryAsset::class,
        BootstrapPluginAsset::class,
    ];
}
