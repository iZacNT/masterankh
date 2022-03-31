<?php

namespace frontend\controllers;

use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\Controller;

class AjaxController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->enableCsrfValidation = false;
    }

    /**
     * Create url for specific route.
     * @return string
     * @throws Exception
     */
    public function actionCreateurl()
    {
        $route = Yii::$app->request->post('route');
        $params = (array)Yii::$app->request->post('params', []);

        if ($route === null) {
            throw new Exception(400, 'Route not specified');
        }

        $to = [(string)$route];
        $to+= $params;

        return Url::to($to, false);
    }
}
