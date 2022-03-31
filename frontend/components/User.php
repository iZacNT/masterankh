<?php

namespace frontend\components;

use frontend\models\User as UserModel;
use Yii;

/**
 * {@inheritdoc}
 * @property UserModel $identity
 */
class User extends \yii\web\User
{
    /**
     * {@inheritdoc}
     */
    public $identityClass = UserModel::class;

    /**
     * {@inheritdoc}
     */
    public $enableAutoLogin = true;

    /**
     * Logout route.
     * @var array
     */
    public $logoutUrl = ['site/logout'];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->checkStatus();
    }

    /**
     * Check if user is admin.
     * @return bool
     */
    public function isAdmin(): bool
    {
        if (Yii::$app->user->isGuest) return false;
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        return array_key_exists('admin', $roles);
    }

    /**
     * If user is deleted, logout immediately.
     * @return void
     */
    private function checkStatus()
    {
        $user = $this->identity;
        if ($user && $user->status == UserModel::STATUS_DELETED) {
            Yii::$app->response->redirect($this->logoutUrl);
        }
    }
}
