<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'ERP Admin 0.1',
    'version' => 'Alpha 0.1',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'backend\controllers',
    // set target language to be Spanish
    'language' => 'es-GT',
    // set source language to be English
    'sourceLanguage' => 'en-US',
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'i18n' => [
            'translations' => [
                'sys*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'controllers' => ['site'],
                'actions' => ['index','error','request-password-reset','reset-password'],
                'allow' => true,
            ],
            [
                'controllers' => ['gii/default','debug/default'],
                'allow' => true,
            ],
            [
                'actions' => ['login'],//'signup'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    // logout everybody!
    /*'on beforeRequest' => function ($event) {
        if(!\Yii::$app->user->isGuest) {
          Yii::$app->user->logout();
          Yii::$app->getResponse()->redirect(['site/index'])->send();
          return;
        }
    },*/

    'params' => $params,
];
