<?php

namespace frontend\modules\admin\controllers;

use frontend\models\Plan;
use frontend\modules\admin\components\Controller;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

class PlanController extends Controller
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
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * Plans list.
     * @return string
     */
    public function actionIndex()
    {
        $query = Plan::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        return $this->render('index', [
            'provider' => $dataProvider,
        ]);
    }

    /**
     * Update plan.
     * @param int $id - plan ID
     * @return array|string|Response
     */
    public function actionUpdate($id)
    {
        $plan = $this->getModel(Plan::class, $id); /* @var Plan $plan */
        $load = $plan->load($_POST);

        // AJAX validation
        if ($load && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($plan);
        }

        // Saving data
        if ($load && $plan->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'plan' => $plan,
        ]);
    }
}
