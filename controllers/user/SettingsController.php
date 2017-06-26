<?php

namespace app\controllers\user;

use app\models\CommentModel;
use app\models\UploadAvatarForm;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
use dektrium\user\models\Profile;
use Yii;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

/**
 * Clase SettingsController
 */
class SettingsController extends BaseSettingsController
{
    /**
     * Muestra el formulario de configuración del perfil
     *
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $upload = new UploadAvatarForm;

        if (Yii::$app->request->isPost) {
            $upload->imageFile = UploadedFile::getInstance($upload, 'imageFile');

            if ($upload->imageFile != null && !$upload->upload()) {
                $errores = '';

                foreach ($upload->errors as $error) {
                    $errores .= $errores . ' ' . $error[0];
                }

                \Yii::$app->getSession()->setFlash('danger', $errores);
                return $this->redirect(['/settings/profile']);
            }
        }

        $model = $this->finder->findProfileById(\Yii::$app->user->identity->getId());

        if ($model == null) {
            $model = \Yii::createObject(Profile::className());
            $model->link('user', \Yii::$app->user->identity);
        }
        $event = $this->getProfileEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
            $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
            return $this->refresh();
        }

        $genders = ['M' => Yii::t('user', 'Male'), 'F' => Yii::t('user', 'Female')];

        return $this->render('profile', [
            'model' => $model,
            'genders' => $genders,
        ]);
    }

    /**
     * Completely deletes user's account.
     *
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete()
    {
        if (!$this->module->enableAccountDelete) {
            throw new NotFoundHttpException(\Yii::t('user', 'Not found'));
        }

        $user  = \Yii::$app->user->identity;
        $event = $this->getUserEvent($user);

        \Yii::$app->user->logout();

        $this->trigger(self::EVENT_BEFORE_DELETE, $event);
        $user->delete();
        $this->trigger(self::EVENT_AFTER_DELETE, $event);

        CommentModel::deleteAll(['"createdBy"' => $user->id]);

        return $this->goHome();
    }
}
