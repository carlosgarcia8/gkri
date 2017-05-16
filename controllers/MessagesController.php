<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Message;
use app\models\MessageForm;
use app\models\Notificacion;
use app\models\enums\NotificationType;
use dektrium\user\filters\AccessRule;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;

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
    // TODO cuando se haga create desde el perfil del usuario actualizar las conversaciones para traerla de nuevo, por si no existe
    public function actionCreate()
    {
        $messageForm = new MessageForm;

        if ($messageForm->load(Yii::$app->request->post())) {
            if ($messageForm->validate()) {
                $message = new Message;
                $message->user_id = Yii::$app->user->id;
                $message->receptor_id = $messageForm->receptor_id;
                $message->texto = $messageForm->texto;
                if ($message->save()) {
                    $notificacion = new Notificacion();

                    $notificacion->type = NotificationType::MENSAJE_NUEVO;
                    $notificacion->user_id = $message->receptor_id;
                    $notificacion->user_related_id = $message->user_id;

                    $notificacion->save();
                }
            } else {
                throw new BadRequestHttpException;
            }
        } else {
            throw new BadRequestHttpException;
        }
    }

    public function actionObtener($contact_id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: AJAX');
        }

        if (User::findOne(['id' => $contact_id]) == null) {
            throw new BadRequestHttpException();
        }

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
