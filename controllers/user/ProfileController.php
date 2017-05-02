<?php

namespace app\controllers\user;

use dektrium\user\controllers\ProfileController as BaseProfileController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\CommentModel;
use yii\filters\AccessControl;
use app\models\UploadAvatarForm;
use Yii;
use yii\web\UploadedFile;

class ProfileController extends BaseProfileController
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['index'], 'roles' => ['@']],
                    ['allow' => true, 'actions' => ['show', 'votados', 'comentarios'], 'roles' => ['?', '@']],
                ],
            ],
        ];
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
            $model->upload();
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
