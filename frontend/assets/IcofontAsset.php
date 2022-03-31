<?php

namespace frontend\assets;

use Yii;
use yii\helpers\Html;
use yii\web\AssetBundle;

/**
 * Class IcofontAsset
 * @link https://icofont.com
 *
 * IcofontAsset::icon('check');
 * IcofontAsset::icon('close', 2);
 */
class IcofontAsset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $css = [
        'icofont/icofont.min.css',
    ];

    /**
     * {@inheritdoc}
     */
    public $sourcePath = '@frontend/assets/src';

    /**
     * Register asset and generate icon.
     * @param string $name - icon name
     * @param string|int $size - size (1,2,3,4,5,6,7,8,9,10,xs,sm,md,lg)
     * @param array $options - HTML-attributes
     * @return string
     */
    public static function icon(string $name, $size = 'lg', array $options = []): string
    {
        self::register(Yii::$app->view);
        if (is_int($size)) {
            $class = "icofont-{$size}x";
        } elseif (is_string($size)) {
            $class = "icofont-{$size}";
        }
        Html::addCssClass($options, "icofont-{$name}");
        Html::addCssClass($options, $class);
        return Html::tag('i', '', $options);
    }
}
