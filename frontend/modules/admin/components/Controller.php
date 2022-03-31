<?php

namespace frontend\modules\admin\components;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\Url;

abstract class Controller extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function redirect($url, $statusCode = 302)
    {
        $redirect = Yii::$app->request->get('redirect');
        $url = $redirect === null ? $url : $redirect;
        return parent::redirect($url, $statusCode);
    }

    /**
     * Get model by ID or throw exception.
     * @param string $modelName - class name of model: SomeModel::class
     * @param int $id - record ID
     * @return ActiveRecord
     * @throws Exception
     */
    protected function getModel(string $modelName, int $id)
    {
        /* @var ActiveRecord $modelName */
        $model = $modelName::findOne($id);
        if (!$model) {
            throw new Exception(404);
        }
        return $model;
    }
}
