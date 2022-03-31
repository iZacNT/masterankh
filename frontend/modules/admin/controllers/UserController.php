<?php

namespace frontend\modules\admin\controllers;

use frontend\models\User;
use frontend\models\UserSearch;
use frontend\modules\admin\components\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UserController extends Controller
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
     * Users list.
     * @return string
     */
    public function actionIndex()
    {
        $search = new UserSearch;
        $provider = $search->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'search' => $search,
            'provider' => $provider,
        ]);
    }

    /**
     * Update user.
     * @param int $id - user ID
     * @return array|string|Response
     */
    public function actionUpdate($id)
    {
        $user = $this->getModel(User::class, $id); /* @var User $user */
        $load = $user->load($_POST);

        // AJAX validation
        if ($load && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        // Saving data
        if ($load && $user->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'user' => $user,
        ]);
    }

    /**
     * Delete user (set status - deleted).
     * @param int $id - user ID
     * @return Response
     */
    public function actionDelete($id)
    {
        $user = $this->getModel(User::class, $id); /* @var User $user */
        $user->delete();
        return $this->redirect(['index']);
    }
}
