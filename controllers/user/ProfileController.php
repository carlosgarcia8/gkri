<?php

namespace app\controllers\user;

use app\models\User;
use app\models\Notificacion;
use dektrium\user\controllers\ProfileController as BaseProfileController;
use dektrium\user\filters\AccessRule;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use app\models\CommentModel;
use yii\filters\AccessControl;
use app\models\UploadAvatarForm;
use Yii;
use yii\web\UploadedFile;
use yii\web\MethodNotAllowedHttpException;

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
                    ['allow' => true, 'actions' => ['index', 'notifications-ajax', 'notifications-read-ajax'], 'roles' => ['@']],
                    ['allow' => true, 'actions' => ['show', 'votados', 'comentarios'], 'roles' => ['?', '@']],
                ],
            ],
        ];
    }

    public function actionNotificationsAjax()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException();
            ;
        }
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: AJAX');
        }

        $query = new Query;
        $query->select(['notificaciones.*', 'left(posts.titulo,15) as titulo', 'posts.extension'])
            ->from('notificaciones')
            ->join('JOIN', 'posts', 'notificaciones.post_id = posts.id')
            ->where(['notificaciones.user_id' => Yii::$app->user->identity->id, 'seen' => false]);

        return Json::encode($query->all());
    }

    public function actionNotificationsReadAjax($id)
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException();
        }
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: AJAX');
        }

        if ($id == 0) {
            Notificacion::updateAll(['seen' => true], ['user_id' => Yii::$app->user->identity->id]);
        } else {
            $notificacion = Notificacion::findOne(['id' => $id]);
            $notificacion->seen = true;
            $notificacion->update();
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

        if (Yii::$app->request->isPost) {
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

        return $this->render('show', [
            'profile' => $profile,
            'model' => $model,
            'suPerfil' => $suPerfil,
            'dataProvider' => $dataProvider,
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

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->upload();
        }
        $user = $this->finder->findUserByUsername($username);

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

        return $this->render('show', [
            'profile' => $profile,
            'model' => $model,
            'suPerfil' => $suPerfil,
            'dataProvider' => $dataProvider,
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

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->upload();
        }
        $user = $this->finder->findUserByUsername($username);

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

        return $this->render('show-comentarios', [
            'profile' => $profile,
            'model' => $model,
            'suPerfil' => $suPerfil,
            'dataProvider' => $dataProvider,
        ]);
    }
}
