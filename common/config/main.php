<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'imageCache' => [
            'class' => '\common\components\ImageCache',
        ],
        'notification' => [
            'class' => '\common\components\AlertNotification',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => "194818044841862",
                    'clientSecret' => "1a1bdc970c0e441c3a219ff5f0ddd568",
                ],
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6Le9WoAUAAAAAHaTtKqnBmxuYW8DHTfAU2v4v5iL',
            'secret' => '6Le9WoAUAAAAALQ_0w2vDeDxn1zGBYW29SGYKmsW',
        ],
        'i18n' => [
            'class' => '\common\lib\i18nModule\components\I18n',
            'messageSourceConfig' => [
                'class' => \yii\i18n\DbMessageSource::className(),
                'enableCaching' => false,
                'forceTranslation' => true,
            ],
            'handleMissing' => true,
            'override' => true,
            'languages' => ['en', 'ar'],
        ],
        'mobileDetect' => [
            'class' => '\skeeks\yii2\mobiledetect\MobileDetect'
        ],
        'recaptchaV3' => [
            'class' => 'Baha2Odeh\RecaptchaV3\RecaptchaV3',
            'site_key' => '6Ld8MMgZAAAAABaifZEb0l3Z9Uix-g2n15WAeMwC',
            'secret_key' => '6Ld8MMgZAAAAADn0zLwXoT44eq_wxcURZfQ1fXKI',
            'verify_ssl' => true, // default is true
        ],
    ],
];
