<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'name' => "Ecommerce",
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'ipHeaders' => [
                'CF_CONNECTING_IP',
                'X-Forwarded-For',
            ],
            'secureProtocolHeaders' => [
                'X-Forwarded-Proto' => ['https'], // Common
                'Front-End-Https' => ['on'], // Microsoft
                'cf-visitor' => ['{"scheme":"https"}']
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
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
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'cdn/cache/<size:\w+>/<path:.+>' => 'image-resize/index',
                'home' => 'site/index',
                'login' => 'site/login',
                'sign-up' => 'site/signup',
                'my-profile' => 'user/view',
                '<controller:[\w-]+>s' => '<controller>',
                '<controller:[\w-]+>/<id:\d+>' => '<controller>/view',
                '<controller:[\w-]+>/<id:\d+>' => '<controller>/delete',
                '<controller:[\w-]+>/<id:\d+>' => '<controller>/update',

            ],
        ],
    ],
    'params' => $params,
];
