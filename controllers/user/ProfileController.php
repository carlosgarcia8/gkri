<?php

namespace app\controllers\user;

use dektrium\user\controllers\ProfileController as BaseProfileController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\UploadAvatarForm;
use Yii;
use yii\web\UploadedFile;

class ProfileController extends BaseProfileController
{

/**
 * Muestra el perfil del usuario
 *
 * @param int $id
 *
 * @return \yii\web\Response
 * @throws \yii\web\NotFoundHttpException
 */

    public function actionShow($username)
    {
        // $dataProvider =  new ActiveDataProvider([
        //     'pagination' => [
        //         'pageSize' => 10,
        //     ]
        // ]);
        $model = new UploadAvatarForm;

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->upload();
        }
        $user = $this->finder->findUserByUsername($username);

        $profile = $this->finder->findProfileById($user->id);

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        $suPerfil = Yii::$app->user->id === $profile->user_id;

        return $this->render('show', [
            'profile' => $profile,
            'model' => $model,
            // 'dataProvider' => $dataProvider,
            'suPerfil' => $suPerfil,
        ]);
    }
}
