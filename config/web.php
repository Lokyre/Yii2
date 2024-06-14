<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'cK-_a0tILP3HgAy8dBUO2yJHd65djUKK',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/yiibd',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'libro'],
                'POST libro' => 'libro/create', // Esto mapea las solicitudes POST a /libros a actionCreate en LibroController
                'GET libro' => 'libro/index', // Esto mapea las solicitudes GET a /libros a actionIndex en LibroController
                'GET libro/<id:[a-f0-9]{24}>' => 'libro/view',
                'PUT libro/<id:[a-f0-9]{24}>' => 'libro/update', // Esto mapea las solicitudes PUT a /libros/1 a actionUpdate en LibroController
                'DELETE libro/<id:[a-f0-9]{24}>' => 'libro/delete',

                'POST autor' => 'autor/create',
                'GET autor' => 'autor/index',
                'GET autor/<id:[a-f0-9]{24}>' => 'autor/view',
                'PUT autor/<id:[a-f0-9]{24}>' => 'autor/update',
                'DELETE autor/<id:[a-f0-9]{24}>' => 'autor/delete',
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'autor'],
                // ['class' => 'yii\rest\UrlRule', 'controller' => 'autor-libro'],
            ],
        ],

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
