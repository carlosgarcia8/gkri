<?php

namespace app\models;

use dektrium\user\models\Profile as BaseProfile;
use Yii;

class Profile extends BaseProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'bioString'            => ['bio', 'string'],
            'timeZoneValidation'   => ['timezone', 'validateTimeZone'],
            'publicEmailPattern'   => ['public_email', 'email'],
            'gravatarEmailPattern' => ['gravatar_email', 'email'],
            'websiteUrl'           => ['website', 'url'],
            'nameLength'           => ['name', 'string', 'max' => 255],
            'publicEmailLength'    => ['public_email', 'string', 'max' => 255],
            'gravatarEmailLength'  => ['gravatar_email', 'string', 'max' => 255],
            'locationLength'       => ['location', 'string', 'max' => 255],
            'websiteLength'        => ['website', 'string', 'max' => 255],
            'gender'               => ['gender', 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'           => \Yii::t('user', 'Name'),
            'public_email'   => \Yii::t('user', 'Email (public)'),
            'gravatar_email' => \Yii::t('user', 'Gravatar email'),
            'location'       => \Yii::t('user', 'Location'),
            'website'        => \Yii::t('user', 'Website'),
            'bio'            => \Yii::t('user', 'Bio'),
            'timezone'       => \Yii::t('user', 'Time zone'),
            'gender'         => \Yii::t('user', 'Gender'),
        ];
    }

    /**
     * Se obtiene la ruta hacia el avatar del usuario, si no tiene se le
     * da un avatar por defecto
     * @return string ruta hacia el avatar
     */
    public function getAvatar()
    {
        $uploadsAvatar = Yii::getAlias('@avatar');

        $result = glob($uploadsAvatar . "/$this->user_id.*");
        if (count($result) != 0) {
            $ruta = $result[0];
        } else {
            $ruta = $uploadsAvatar . "/$this->user_id.jpg";
        }

        $s3 = Yii::$app->get('s3');

        /*
         * Funcionalidad creada para que cuando el fichero no exista localmente
         * lo guarde de tal manera que cuando este guardado en el contenedor
         * se sirva de ese fichero y no tenga que pedirlo mas a amazon s3, de esta
         * manera ganamos eficiencia.
         */
        if (file_exists($ruta)) {
            return "/$ruta";
        } elseif ($s3->exist($ruta)) {
            $s3->commands()->get($ruta)->saveAs($ruta)->execute();
            return "/$ruta";
        } else {
            return "/$uploadsAvatar/default.jpg";
        }
    }
}
