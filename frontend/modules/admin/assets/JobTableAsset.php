<?php

namespace frontend\modules\admin\assets;

use frontend\assets\Bootstrap4Asset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class JobTableAsset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $js = [
        'script.js',
    ];

    /**
     * {@inheritdoc}
     */
    public $sourcePath = '@frontend/modules/admin/assets/src/JobTableAsset';

    /**
     * {@inheritdoc}
     */
    public $depends = [
        JqueryAsset::class,
        Bootstrap4Asset::class,
    ];
}
