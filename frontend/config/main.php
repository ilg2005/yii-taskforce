<?php

use frontend\components\MyFormatter;
use frontend\models\User;
use yii\i18n\PhpMessageSource;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'on beforeAction' => static function() {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $user->latest_activity_time = date('Y-m-d H:i:s');
            $user->update();
        }
    },
    'components' => [
        'formatter' => [
            'defaultTimeZone' => 'Europe/Moscow',
            'class' => MyFormatter::class,
            ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'ru-RU',
                    'fileMap' => [
                        'app'       => 'app.php',
                    ],
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'taskforce-site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
                '/' => 'taskforce-site/index',
                'defaultRoute' => 'taskforce-site/index',

                'browse/<page:\d+>' => 'taskforce-site/browse',
                '<action:(index|account|browse|create|mylist|profile|signup|users|view|image|logout|error)>' => 'taskforce-site/<action>',
            ],
        ],

    ],
    'params' => $params,
];
