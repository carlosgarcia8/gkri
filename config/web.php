<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'GKRI',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'posts/index',
    'aliases' => [
        '@uploads' => 'uploads',
        '@avatar' => 'uploads/avatar',
        '@posts' => 'uploads/posts',
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableAccountDelete' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['xharly8'],
            'mailer' => [
                'sender'                => 'globalklingonradianimaginary@gmail.com',
                'welcomeSubject'        => 'Bienvenido a GKRI',
                'confirmationSubject'   => 'Mensaje de Confirmación',
                'reconfirmationSubject' => 'Cambio de Email',
                'recoverySubject'       => 'Recuperación de Contraseña',
            ],
            'urlRules' =>  [
                '<action:(login|logout|auth)>'           => 'security/<action>',
                '<action:(register|resend)>'             => 'registration/<action>',
                'confirm/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'registration/confirm',
                'forgot'                                 => 'recovery/request',
                'recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'recovery/reset',
            ],
            'controllerMap' => [
                'registration' => [
                    'class' => \dektrium\user\controllers\RegistrationController::className(),
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_REGISTER => function ($e) {
                        Yii::$app->response->redirect(['/user/security/login'])->send();
                        Yii::$app->end();
                    }
                ],
                'profile' => 'app\controllers\user\ProfileController',
                'settings' => 'app\controllers\user\SettingsController',
                'recovery' => 'app\controllers\user\RecoveryController',
            ],
            'modelMap' => [
                'Profile' => 'app\models\Profile',
                'User' => 'app\models\User',
                'SettingsForm' => 'app\models\SettingsForm',
                'RecoveryForm' => 'app\models\RecoveryForm',
            ],
        ],
        // 'comment' => [
        //     'class' => 'yii2mod\comments\Module',
        // ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'faL_UO-zHBG6WGBep13AtKQdDhUsiqd8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user',
                ],
            ],
        ],
        's3' => [
        'class' => 'frostealth\yii2\aws\s3\Service',
        'credentials' => [ // Aws\Credentials\CredentialsInterface|array|callable
            'key' => getenv('AWS_KEY'),
            'secret' => getenv('AWS_SECRET'),
        ],
            'region' => 'eu-west-2',
            'defaultBucket' => 'gkri',
            'defaultAcl' => 'public-read',
        ],
        // 'user' => [
        //     'identityClass' => 'app\models\User',
        //     'enableAutoLogin' => true,
        // ],
        'authClientCollection' => [
            'class'   => \yii\authclient\Collection::className(),
            'clients' => [
                'google' => [
                    'class'        => 'dektrium\user\clients\Google',
                    'clientId'     => getenv('GOOGLE_ID'),
                    'clientSecret' => getenv('GOOGLE_PASS'),
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'globalklingonradianimaginary@gmail.com',
                'password' => getenv('SMTP_PASS'),
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            // 'db' => 'mydb',
            // 'sessionTable' => 'my_session',
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'u/<username:\w+>'      => 'user/profile/show',
                'settings/<action:\w+>' => 'user/settings/<action>'
                // 'entrada/<id:\d>' => 'entradas/view',
                // 'entrada/enviar' => 'entradas/create',
                // 'entrada/categoria/<categoria_id:\d>' => 'entradas/index',
                // 'entrada/etiqueta/<etiqueta_id:\d>' => 'entradas/index',
                // 'entrada/meneo' => 'entradas/meneo'
            ],
        ],

        'i18n' => [
            'translations' => [
                // 'yii2mod.comments' => [
                //     'class' => 'yii\i18n\PhpMessageSource',
                //     'basePath' => '@app/messages',
                // ],
                'user*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'user' => 'user.php',
                    ],
                ]
            ],
        ],

    ],
    'language' => 'es_ES',
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
