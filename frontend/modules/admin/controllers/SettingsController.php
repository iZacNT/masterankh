<?php

namespace frontend\modules\admin\controllers;

use frontend\models\User;
use frontend\modules\admin\components\Controller;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SettingsController extends Controller
{
    /**
     * User profile.
     * @return array|string|Response
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity; /* @var User $user */
        $load = $user->load(Yii::$app->request->post());

        // AJAX validation
        if ($load && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        // Saving data
        if ($load && $user->save()) {
            return $this->refresh();
        }

        return $this->render('index', [
            'user' => $user,
        ]);
    }
}
