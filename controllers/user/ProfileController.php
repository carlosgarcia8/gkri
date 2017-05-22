<?php

namespace app\controllers\user;

use app\models\Follow;
use app\models\MessageForm;
use app\models\Notificacion;
use app\models\enums\NotificationType;
use dektrium\user\controllers\ProfileController as BaseProfileController;
use dektrium\user\filters\AccessRule;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\models\CommentModel;
use yii\filters\AccessControl;
use app\models\UploadAvatarForm;
use Yii;
use yii\web\UploadedFile;
use yii\web\MethodNotAllowedHttpException;

/**
 * Clase ProfileController
 */
class ProfileController extends BaseProfileController
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    ['allow' => true, 'actions' => ['index', 'notifications-ajax', 'notifications-read-ajax', 'notifications-follow-ajax'], 'roles' => ['@']],
                    ['allow' => true, 'actions' => ['show', 'votados', 'comentarios'], 'roles' => ['?', '@']],
                ],
            ],
        ];
    }

    /**
     * Realiza la busqueda de notificaciones del usuario
     * @return mixed
     */
    public function actionNotificationsAjax()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException();
        }
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: AJAX');
        }

        $query = new Query;
        $query->select(['notificaciones.type', 'notificaciones.post_id', 'left(posts.titulo,15) as titulo', 'count(*)', 'max(notificaciones.created_at) as fecha'])
            ->from('notificaciones')
            ->join('JOIN', 'posts', 'notificaciones.post_id = posts.id')
            ->where([
                'notificaciones.user_id' => Yii::$app->user->identity->id,
                'seen' => false,
                'type' => [NotificationType::POST_ACEPTADO, NotificationType::VOTADO, NotificationType::COMENTADO, NotificationType::REPLY],
            ])
            ->groupBy('type, post_id, titulo');

        $data_p = $query->all();

        $query = new Query;
        $query->select(['notificaciones.type', 'notificaciones.post_id', 'notificaciones.user_related_id', 'public.user.username', 'notificaciones.created_at as fecha'])
            ->from('notificaciones')
            ->join('JOIN', 'public.user', 'notificaciones.user_related_id = public.user.id')
            ->where([
                'notificaciones.user_id' => Yii::$app->user->identity->id,
                'seen' => false,
                'notificaciones.type' => [NotificationType::SEGUIDOR_NUEVO, NotificationType::POST_NUEVO, NotificationType::MENSAJE_NUEVO],
            ]);

        $data = array_merge($data_p, $query->all());

        ArrayHelper::multisort($data, 'fecha', SORT_DESC);

        return Json::encode($data);
    }

    /**
     * Cambia el estado de la/las notificaciones
     * @param  int $type tipo de notificacion
     * @param  int $id   id del post/comentario/user_related
     */
    public function actionNotificationsReadAjax($type, $id)
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException();
        }
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: AJAX');
        }

        if ($id == 0 && $type == -1) {
            Notificacion::updateAll(['seen' => true], ['user_id' => Yii::$app->user->identity->id]);
        } elseif ($type == 3 || $type == 6) {
            Notificacion::updateAll(['seen' => true], ['type' => $type, 'user_id' => Yii::$app->user->identity->id, 'user_related_id' => $id]);
        } else {
            Notificacion::updateAll(['seen' => true], ['type' => $type, 'post_id' => $id]);
        }
    }

    /**
     * Muestra el perfil del usuario con los posts subidos y aprobados
     *
     * @param string $username
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow($username)
    {
        $model = new UploadAvatarForm;
        $messageForm = new MessageForm;

        if (Yii::$app->request->isPost) {
            if (Yii::$app->user->isGuest) {
                return $this->redirect(['/user/security/login']);
            }
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (!$model->upload()) {
                $errores = '';

                foreach ($model->errors as $error) {
                    $errores .= $errores . ' ' . $error[0];
                }

                \Yii::$app->getSession()->setFlash('error', $errores);
                return $this->redirect(['/u/' . $username]);
            }
        }
        $user = $this->finder->findUserByUsername($username);

        if ($user === null) {
            \Yii::$app->getSession()->setFlash('nouser', 'No existe ningun usuario con ese nombre. Se le redireccionará a la página principal en 5 segundos...');
            return $this->render('show', [
                'profile' => null,
                'username' => $username,
            ]);
        }

        $profile = $this->finder->findProfileById($user->id);

        $dataProvider = new ActiveDataProvider([
            'query' => $user->getPosts()->orderBy('fecha_confirmacion desc')->approved(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        $suPerfil = Yii::$app->user->id === $profile->user_id;

        $esSeguidor = Follow::findOne(['user_id' => Yii::$app->user->id, 'follow_id' => $user->id]) !== null;

        $numeroSeguidores = $user->getSeguidores()->count();

        $numeroSiguiendo = $user->getSiguiendo()->count();

        return $this->render('show', [
            'profile' => $profile,
            'model' => $model,
            'suPerfil' => $suPerfil,
            'dataProvider' => $dataProvider,
            'numeroSeguidores' => $numeroSeguidores,
            'numeroSiguiendo' => $numeroSiguiendo,
            'esSeguidor' => $esSeguidor,
            'messageForm' => $messageForm,
        ]);
    }

    /**
     * Muestra el perfil del usuario con los posts votados
     *
     * @param string $username
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionVotados($username)
    {
        $model = new UploadAvatarForm;
        $messageForm = new MessageForm;

        if (Yii::$app->request->isPost) {
            if (Yii::$app->user->isGuest) {
                return $this->redirect(['/user/security/login']);
            }
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (!$model->upload()) {
                $errores = '';

                foreach ($model->errors as $error) {
                    $errores .= $errores . ' ' . $error[0];
                }

                \Yii::$app->getSession()->setFlash('error', $errores);
                return $this->redirect(['/u/' . $username]);
            }
        }
        $user = $this->finder->findUserByUsername($username);

        if ($user === null) {
            \Yii::$app->getSession()->setFlash('nouser', 'No existe ningun usuario con ese nombre. Se le redireccionará a la página principal en 5 segundos...');
            return $this->render('show', [
                'profile' => null,
                'username' => $username,
            ]);
        }

        $profile = $this->finder->findProfileById($user->id);

        $dataProvider = new ActiveDataProvider([
            'query' => $user->getPostsVotadosPositivos(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        $suPerfil = Yii::$app->user->id === $profile->user_id;

        $esSeguidor = Follow::findOne(['user_id' => Yii::$app->user->id, 'follow_id' => $user->id]) !== null;

        $numeroSeguidores = $user->getSeguidores()->count();

        $numeroSiguiendo = $user->getSiguiendo()->count();

        return $this->render('show', [
            'profile' => $profile,
            'model' => $model,
            'suPerfil' => $suPerfil,
            'dataProvider' => $dataProvider,
            'numeroSeguidores' => $numeroSeguidores,
            'numeroSiguiendo' => $numeroSiguiendo,
            'esSeguidor' => $esSeguidor,
            'messageForm' => $messageForm,
        ]);
    }

    /**
     * Muestra el perfil del usuario con los posts donde ha comentado
     *
     * @param string $username
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionComentarios($username)
    {
        $model = new UploadAvatarForm;
        $messageForm = new MessageForm;

        if (Yii::$app->request->isPost) {
            if (Yii::$app->user->isGuest) {
                return $this->redirect(['/user/security/login']);
            }
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (!$model->upload()) {
                $errores = '';

                foreach ($model->errors as $error) {
                    $errores .= $errores . ' ' . $error[0];
                }

                \Yii::$app->getSession()->setFlash('error', $errores);
                return $this->redirect(['/u/' . $username]);
            }
        }
        $user = $this->finder->findUserByUsername($username);

        if ($user === null) {
            \Yii::$app->getSession()->setFlash('nouser', 'No existe ningun usuario con ese nombre. Se le redireccionará a la página principal en 5 segundos...');
            return $this->render('show', [
                'profile' => null,
                'username' => $username,
            ]);
        }

        $profile = $this->finder->findProfileById($user->id);

        $subquery = CommentModel::find()
            ->select(['"entityId"', 'max("createdAt")'])
            ->where(['"createdBy"' => $user->id])
            ->groupBy(['"createdBy"', '"entityId"']);
        $query = CommentModel::find()
            ->where(['"createdBy"' => $user->id])
            ->andWhere(['in', '("entityId", "createdAt")', $subquery])
            ->orderBy('"createdAt" desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        $suPerfil = Yii::$app->user->id === $profile->user_id;

        $esSeguidor = Follow::findOne(['user_id' => Yii::$app->user->id, 'follow_id' => $user->id]) !== null;

        $numeroSeguidores = $user->getSeguidores()->count();

        $numeroSiguiendo = $user->getSiguiendo()->count();

        return $this->render('show-comentarios', [
            'profile' => $profile,
            'model' => $model,
            'suPerfil' => $suPerfil,
            'dataProvider' => $dataProvider,
            'numeroSeguidores' => $numeroSeguidores,
            'numeroSiguiendo' => $numeroSiguiendo,
            'esSeguidor' => $esSeguidor,
            'messageForm' => $messageForm,
        ]);
    }
}
