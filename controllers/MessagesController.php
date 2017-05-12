<?php

namespace app\controllers;

use Yii;
use app\models\Message;
use app\models\MessageForm;
use dektrium\user\filters\AccessRule;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class MessagesController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $messageForm = new MessageForm;

        if ($messageForm->load(Yii::$app->request->post())) {
            if ($messageForm->validate()) {
                $message = new Message;
                $message->user_id = Yii::$app->user->id;
                $message->receptor_id = $messageForm->receptor_id;
                $message->texto = $messageForm->texto;
                $message->save();
            }
        }
    }
}
