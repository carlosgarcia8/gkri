<?php

namespace app\controllers;

use Yii;
use app\models\Message;
use app\models\MessageForm;
use dektrium\user\filters\AccessRule;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;

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
                'only' => ['create', 'obtener'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'obtener'],
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

    // TODO solo sea para los no guest y solo ajax
    public function actionObtener($contact_id)
    {
        $user_id = Yii::$app->user->id;

        $query = new Query;
        $query->select(['texto', "to_char(m.created_at, 'DD/MM/YYYY HH24:MI:SS') as fecha", 'm.user_id', 'm.receptor_id', 'e.username as emisor', 'r.username as receptor'])
            ->from('messages as m')
            ->join('join', 'public.user as e', 'm.user_id=e.id')
            ->join('join', 'public.user as r', 'm.receptor_id=r.id')
            ->where("user_id=$user_id and receptor_id=$contact_id or user_id=$contact_id and receptor_id=$user_id")
            ->orderBy('fecha desc');

        $messages = $query->all();

        return Json::encode($messages);
    }
}
