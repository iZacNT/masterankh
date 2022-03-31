<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class RbacController extends Controller
{
    /**
     * Add roles: user and admin.
     * php yii rbac/init
     * @return int
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add role "user"
        $user = $auth->createRole('user');
        $auth->add($user);

        // add role "admin"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $user);

        return ExitCode::OK;
    }

    /**
     * Assign to user role.
     * php yii rbac/role user 1
     * @param string $name - role name
     * @param int $id - user ID
     * @return int
     */
    public function actionRole($name, $id)
    {
        if (!isset($name, $id)) return ExitCode::UNSPECIFIED_ERROR;

        $role = Yii::$app->authManager->getRole($name);
        if (!$role) return ExitCode::UNSPECIFIED_ERROR;

        Yii::$app->authManager->assign($role, $id);

        return ExitCode::OK;
    }
}
