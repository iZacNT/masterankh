<?php

$config = [
    'id' => 'Genieping',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'admin' => [
            'class' => \frontend\modules\admin\Module::class,
            'defaultRoute' => 'main/index',
        ],
        'gridview' => [
            'class' => \kartik\grid\Module::class
        ],
    ],
    'components' => [
        'request' => [
            'class' => \frontend\components\LangRequest::class,
            'cookieValidationKey' => 'fdg@TFREGFEDA%fdsfsdgf', // A secret key is required by cookie validation
            'baseURL' => '',
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
        ],
        'user' => [
            'class' => \frontend\components\User::class,
        ],
        'view' => [
            'class' => \frontend\components\View::class,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'class' => \frontend\components\LangUrlManager::class,
            'rules' => [
                [
                    'pattern' => '/page/<name:\w+>',
                    'route' => 'page/index',
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => \yii\i18n\DbMessageSource::class,
                    'messageTable' => 'translations',
                    'sourceMessageTable' => 'translations_source',
                    'sourceLanguage' => 'ru',
                ],
            ],
        ],
        'reCaptcha' => require __DIR__ . '/captcha.php',
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '777682735881-7p6qp11een5gto37sda22pbqm7j2gfgl.apps.googleusercontent.com',
                    'clientSecret' => 'mHw2LOqdkGLsw0s05JtmwWhi',
                    'returnUrl' => 'https://www.genieping.com/en/site/auth?authclient=google',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '306855784278587',
                    'clientSecret' => '3db0f9f0e04e21af3fa44d07c36a060b',
                ],
                // etc.
            ],
        ]
    ],
    'container' => [
        'definitions' => [
            \yii\widgets\LinkPager::class => \yii\bootstrap4\LinkPager::class,
            \yii\bootstrap4\LinkPager::class => [
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'
            ]
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\debug\Module::class,
    ];
}

return $config;
