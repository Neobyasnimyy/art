<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
//    глобальное изменение шаблона
//    'layout'=>'basic',
//    глобальное изменение языка
    'language' => 'ru',
    'defaultRoute'=>'site/index',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' =>'admin',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'P-fXG7QO2bGnb-jHXeIpbudR0GtsaHgV',
            'baseUrl'=> '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true, // авторизация пользователя на основе куки,при login пользователя
            //'loginUrl' =>'cart/view', // куда будет отправлент пользователь если он авторизован
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true, // включает ЧПУ
            'showScriptName' => false, // показывать имя скрипта
            'enableStrictParsing' => false, // включает жесткие взаимодействия с правилами rules
//            'suffix'=>'.html', //
            'rules' => [
                '<action:(about|contact|login|register)>' => 'site/<action>',
            ],
        ],
    ],
    'aliases' => [
        '@uploads' => '@app/web/uploads',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
