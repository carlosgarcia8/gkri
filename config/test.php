<?php

use app\models\Notificacion;
use app\models\enums\NotificationType;
use yii2mod\comments\models\CommentModel;

$params = require(__DIR__ . '/params.php');
$dbParams = require(__DIR__ . '/test_db.php');

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'name' => 'GKRI',
    'basePath' => dirname(__DIR__),
    'language' => 'es-ES',
    'defaultRoute' => 'posts/index',
    'aliases' => [
        '@uploads' => 'uploads',
        '@avatar' => 'uploads/avatar',
        '@posts' => 'uploads/posts',
        '@generador' => 'images/generador',
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableAccountDelete' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['xharly8'],
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
                'RegistrationForm' => 'app\models\RegistrationForm',
            ],
        ],
        'comment' => [
            'class' => 'yii2mod\comments\Module',
            'commentModelClass' =>  'app\models\CommentModel',
            'controllerMap' => [
                'default' => [
                    'class' => 'app\controllers\comments\DefaultController',
                    'on afterDelete' => function ($event) {
                        $comment = $event->getCommentModel();
                        CommentModel::deleteAll(['id' => $comment->id]);
                    },
                    'on beforeCreate' => function ($event) {
                        CommentModel::deleteAll(['status' => 2]);
                    },
                    'on afterCreate' => function ($event) {
                        $comment = $event->getCommentModel();
                        $post = $comment->post;

                        if ($comment->parentId !== null) {
                            $commentPadre = CommentModel::findOne(['id' => $comment->parentId]);

                            if ($commentPadre->createdBy !== $comment->createdBy) {
                                $notificacion = new Notificacion();

                                $notificacion->type = NotificationType::REPLY;
                                $notificacion->user_id = $commentPadre->createdBy;
                                $notificacion->post_id = $post->id;
                                $notificacion->comment_id = $comment->id;

                                $notificacion->save();
                            }
                        }

                        if (Yii::$app->user->identity->id !== $post->usuario_id) {
                            $notificacion = new Notificacion();

                            $notificacion->type = NotificationType::COMENTADO;
                            $notificacion->user_id = $post->usuario_id;
                            $notificacion->post_id = $post->id;
                            $notificacion->comment_id = $comment->id;

                            $notificacion->save();
                        }
                    },
                ],
            ],
        ],
    ],
    'components' => [
        'db' => $dbParams,
        'mailer' => [
            'useFileTransport' => true,
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
            'credentials' => [
                'key' => getenv('AWS_KEY'),
                'secret' => getenv('AWS_SECRET'),
            ],
            'region' => 'eu-west-2',
            'defaultBucket' => 'gkri',
            'defaultAcl' => 'public-read',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'u/<username:\w+>'            => 'user/profile/show',
                'u/<username:\w+>/posts'      => 'user/profile/show',
                'u/<username:\w+>/votados'    => 'user/profile/votados',
                'u/<username:\w+>/comentarios'=> 'user/profile/comentarios',
                'settings/<action:\w+>'       => 'user/settings/<action>',
                'moderar'                     => 'posts/moderar',
                'posts/moderar'               => 'posts/moderar',
                'posts/aceptar/<id:\d+>'      => 'posts/aceptar',
                'posts/rechazar/<id:\d+>'     => 'posts/rechazar',
                'posts/<id:\d+>'              => 'posts/view',
                'posts/search/<q:\w+>'        => 'posts/search',
                'posts/search-ajax/<q:\w+>'   => 'posts/search-ajax',
                'upload'                      => 'posts/upload',
                '<categoria:[\w-]+>'          => 'posts/index',
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
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
    'params' => $params,
];
