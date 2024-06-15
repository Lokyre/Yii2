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
        // Configuración para la base de datos MongoDB
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/yiibd',
        ],
        // Configuración para el componente Auth
        'auth' => [
            'class' => 'app\components\AuthComponent',
        ],
        // Configuración para el componente JWT
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        // Configuración para el componente JWT
        'jwt' => [
            'class' => 'sizeg\jwt\Jwt',
            'jwtKey' => '89M+yJYt5DnEGHhrMIT0QKaG9AcKWy6TlOquL0j+hes=', // Clave secreta para firmar el token
        ],
        // Configuración para el componente de autenticación
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false, // Desactiva las sesiones si solo usas tokens JWT
        ],
        // Configuracion para cache
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
                // Rutas para el controlador Auth
                'POST auth/login' => 'auth/login',
                'POST auth/create' => 'auth/create',

                // Rutas para el controlador Libro
                'POST libro' => 'libro/create', // Esto mapea las solicitudes POST a /libros a actionCreate en LibroController
                'GET libro' => 'libro/index', // Esto mapea las solicitudes GET a /libros a actionIndex en LibroController
                'GET libro/<id:[a-f0-9]{24}>' => 'libro/view',
                'PUT libro/<id:[a-f0-9]{24}>' => 'libro/update', // Esto mapea las solicitudes PUT a /libros/1 a actionUpdate en LibroController
                'DELETE libro/<id:[a-f0-9]{24}>' => 'libro/delete',
                'PUT libro/<id>/add-author' => 'libro/add-author',

                // Rutas para el controlador Autor
                'POST autor' => 'autor/create',
                'GET autor' => 'autor/index',
                'GET autor/<id:[a-f0-9]{24}>' => 'autor/view',
                'PUT autor/<id:[a-f0-9]{24}>' => 'autor/update',
                'DELETE autor/<id:[a-f0-9]{24}>' => 'autor/delete',
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
