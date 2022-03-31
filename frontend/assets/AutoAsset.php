<?php

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

class AutoAsset extends AssetBundle
{
    const BASE_CSS_PATH = '/css/auto';
    const BASE_JS_PATH = '/js/auto';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->registerJs();
        $this->registerCss();
    }

    /**
     * Register JS according to route.
     * @return void
     */
    private function registerJs()
    {
        $route = Yii::$app->controller->getRoute();
        $path = Yii::getAlias('@webroot' . self::BASE_JS_PATH . '/' . $route . '.js');
        if (is_file($path)) {
            $this->js[] = self::BASE_JS_PATH . '/' . $route . '.js';
        }
    }

    /**
     * Register CSS according to route.
     * @return void
     */
    private function registerCss()
    {
        $route = Yii::$app->controller->getRoute();
        $path = Yii::getAlias('@webroot' . self::BASE_CSS_PATH . '/' . $route . '.css');
        if (is_file($path)) {
            $this->js[] = self::BASE_CSS_PATH . '/' . $route . '.css';
        }
    }
}
