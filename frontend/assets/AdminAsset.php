<?php

namespace frontend\assets;

use yii\jui\JuiAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AdminAsset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $basePath = '@webroot';

    /**
     * {@inheritdoc}
     */
    public $baseUrl = '@web';

    /**
     * {@inheritdoc}
     */
    public $css = [
        #'css/bootstrap.css',
        'css/fontawesome.css',
        #'css/icofont.css',
        'css/themify.css',
        #'css/flag-icon.css',
        #'css/feather-icon.css',
        #'css/chartist.css',
        #'css/prism.css',
        'css/style.css',
        #'css/light-1.css',
        #'css/responsive.css',
    ];

    /**
     * {@inheritdoc}
     */
    public $js = [
        #'js/bootstrap/bootstrap.js',
        #'js/index/index.js',
        #'js/bootstrap/popper.min.js',
        #'js/icons/feather-icon/feather.min.js',
        #'js/icons/feather-icon/feather-icon.js',
        #'js/sidebar-menu.js',
        #'js/config.js',
        #'js/chart/chartist/chartist.js',
        #'js/chart/knob/knob.min.js',
        #'js/chart/knob/knob-chart.js',
        #'js/prism/prism.min.js',
        #'js/clipboard/clipboard.min.js',
        #'js/counter/jquery.waypoints.min.js',
        #'js/counter/jquery.counterup.min.js',
        #'js/counter/counter-custom.js',
        #'js/custom-card/custom-card.js',
        #'js/notify/bootstrap-notify.min.js',
        #'js/chat-menu.js',
        #'js/height-equal.js',
        #'js/tooltip-init.js',
        'js/script.js', // fullscreen button
        'js/common.js',
    ];

    /**
     * {@inheritdoc}
     */
    public $depends = [
        YiiAsset::class,
        JuiAsset::class,
        Bootstrap4Asset::class,
        AutoAsset::class,
    ];
}
