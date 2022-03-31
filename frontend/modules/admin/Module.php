<?php

namespace frontend\modules\admin;

class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public $layout = '@frontend/modules/admin/views/layouts/inner';
}
