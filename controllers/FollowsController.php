<?php

namespace app\controllers;

use app\models\User;
use app\models\Follow;
use Yii;
use app\models\Notificacion;
use app\models\enums\NotificationType;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;

class FollowsController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['follow', 'unfollow'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['follow', 'unfollow'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionFollow($follow_id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: AJAX');
        }

        if (User::findOne(['id' => $follow_id]) == null) {
            throw new BadRequestHttpException();
        }

        $user_id = Yii::$app->user->id;
        Yii::trace($user_id);

        if (Follow::findOne(['user_id' => $user_id, 'follow_id' => $follow_id]) !== null) {
            return $this->redirect(['/']);
        }

        $follow = new Follow;
        $follow->user_id = $user_id;
        $follow->follow_id = $follow_id;

        $follow->save();

        $notificacion = new Notificacion();

        $notificacion->type = NotificationType::SEGUIDOR_NUEVO;
        $notificacion->user_id = $follow_id;
        $notificacion->user_related_id = $user_id;

        $notificacion->save();

        return Follow::find(['follow_id' => $follow_id])->count();
    }

    public function actionUnfollow($follow_id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: AJAX');
        }

        if (User::findOne(['id' => $follow_id]) == null) {
            throw new BadRequestHttpException();
        }

        $user_id = Yii::$app->user->id;

        $follow = Follow::findOne(['user_id' => $user_id, 'follow_id' => $follow_id]);

        if ($follow === null) {
            return $this->redirect(['/']);
        }

        $follow->delete();

        Notificacion::deleteAll(['type' => 3, 'user_id' =>  $follow_id, 'user_related_id' => $user_id]);

        return Follow::find(['follow_id' => $follow_id])->count();
    }
}
