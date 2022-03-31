<?php

return [
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
        ],
        'db' => require __DIR__ . '/db.php',
        'mailer' => require __DIR__ . '/mailer.php',
    ],
    'params' => [
        'email' => [
            'info' => 'info@genieping.com',
            'paypal' => 'paypal@genieping.com',
            'help' => 'helpdesk@genieping.com',
        ],
    ],
];
