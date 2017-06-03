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

/**
 * Clase MessagesController
 */
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
                        'actions' => ['create', 'obtener', 'obtener-nuevos'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Crea un mensaje
     * @return mixed
     */
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
                    if (Notificacion::findOne(['type' => 6, 'user_id' => $message->receptor_id, 'user_related_id' => $message->user_id, 'seen' => false]) === null) {
                        $notificacion = new Notificacion();

                        $notificacion->type = NotificationType::MENSAJE_NUEVO;
                        $notificacion->user_id = $message->receptor_id;
                        $notificacion->user_related_id = $message->user_id;

                        $notificacion->save();
                    }
                }
            } else {
                throw new BadRequestHttpException;
            }
        } else {
            throw new BadRequestHttpException;
        }
    }

    /**
     * Obtiene los mensajes de una conversacion en concreto
     * @param  int $contact_id el id del contacto con la que tiene una conversacion
     * @return mixed
     */
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
        $query->select(['m.id', 'texto', 'm.created_at as fecha', 'm.user_id', 'm.receptor_id', 'e.username as emisor', 'r.username as receptor'])
            ->from('messages as m')
            ->join('join', 'public.user as e', 'm.user_id=e.id')
            ->join('join', 'public.user as r', 'm.receptor_id=r.id')
            ->where("user_id=$user_id and receptor_id=$contact_id or user_id=$contact_id and receptor_id=$user_id")
            ->orderBy('m.created_at desc');
        $mensajes = $query->all();

        for ($i = 0; $i < count($mensajes); $i++) {
            $mensajes[$i]['fecha'] = Yii::$app->formatter->asDatetime($mensajes[$i]['fecha'], 'php:d/m/Y H:i:s');
        }

        return Json::encode($mensajes);
    }

    /**
     * Obtiene los mensajes nuevos de las conversaciones activas
     * @param  int $contactos_activos el id del contacto con la que tiene conversaciones activas
     * @return mixed
     */
    public function actionObtenerNuevos($contactos_activos)
    {
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: AJAX');
        }

        if (Yii::$app->user->isGuest) {
            throw new BadRequestHttpException();
        }
        $contactos = \yii\helpers\Json::decode($contactos_activos);

        $user_id = Yii::$app->user->id;

        $data = [];

        foreach ($contactos as $contacto) {
            $query = new Query;
            $query->select(['m.id', 'texto', 'm.created_at as fecha', 'm.user_id', 'm.receptor_id', 'e.username as emisor', 'r.username as receptor'])
            ->from('messages as m')
            ->join('join', 'public.user as e', 'm.user_id=e.id')
            ->join('join', 'public.user as r', 'm.receptor_id=r.id')
            ->where("user_id=$contacto[0] and receptor_id=$user_id and m.id>$contacto[1]")
            ->orderBy('m.created_at desc');

            $data = array_merge($data, $query->all());
        }

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['fecha'] = Yii::$app->formatter->asDatetime($data[$i]['fecha'], 'php:d/m/Y H:i:s');
        }

        return Json::encode($data);
    }
}
