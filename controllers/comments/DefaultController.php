<?php

namespace app\controllers\comments;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii2mod\comments\events\CommentEvent;
use yii2mod\comments\models\CommentModel;
use yii2mod\comments\traits\ModuleTrait;
use yii2mod\editable\EditableAction;
use yii2mod\comments\controllers\DefaultController as BaseDefaultController;

/**
 * Class DefaultController
 *
 * @package yii2mod\comments\controllers
 */
class DefaultController extends BaseDefaultController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['quick-edit', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['quick-edit'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->isAdmin) {
                                return true;
                            }
                            return (
                                CommentModel::find()
                                    ->where(['id' => Yii::$app->request->get('id')])
                                    ->andWhere(['parentId' => null])
                                    ->one() != null
                                ) && (
                                CommentModel::find()
                                    ->where(['parentId' => Yii::$app->request->get('id')])
                                    ->all() == null
                            );
                            // return CommentModel::find()->where(['parentId' => Yii::$app->request->get('id')])->all() == null
                            // || CommentModel::find()->where(['parentId' => null]);
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post', 'delete'],
                ],
            ],
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['create'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }
}
