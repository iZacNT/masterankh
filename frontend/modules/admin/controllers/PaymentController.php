<?php

namespace frontend\modules\admin\controllers;

use frontend\models\Payment;
use frontend\models\PaymentSearch;
use frontend\modules\admin\components\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

class PaymentController extends Controller
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
                        'allow' => true,
                        'actions' => ['user'],
                        'roles' => ['user'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * Payments list.
     * @return string
     */
    public function actionIndex()
    {
        // Payments
        $search = new PaymentSearch;
        $provider = $search->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'search' => $search,
            'provider' => $provider,
        ]);
    }

    /**
     * Payments list.
     * @return string
     */
    public function actionUser()
    {
        // Payments
        $search = new PaymentSearch;
        $provider = $search->search(Yii::$app->request->queryParams, ['user_id' => Yii::$app->user->id]);

        return $this->render('user', [
            'search' => $search,
            'provider' => $provider,
        ]);
    }

    /**
     * Update payment.
     * @param int $id - payment ID
     * @return array|string|Response
     */
    public function actionUpdate($id)
    {
        $payment = $this->getModel(Payment::class, $id); /* @var Payment $payment */
        $payment->setScenario(Payment::SCENARIO_UPDATE);
        $load = $payment->load($_POST);

        // AJAX validation
        if ($load && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($payment);
        }

        // Saving data
        if ($load && $payment->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'payment' => $payment,
        ]);
    }

    /**
     * Delete payment.
     * @param int $id - payment ID
     * @return Response
     */
    public function actionDelete($id)
    {
        $payment = $this->getModel(Payment::class, $id); /* @var Payment $payment */
        $payment->delete();
        return $this->redirect(['index']);
    }
}
