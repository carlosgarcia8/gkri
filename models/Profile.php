<?php

namespace app\models;

use dektrium\user\models\Profile as BaseProfile;
use Yii;
use phpDocumentor\Reflection\Types\String_;

class Profile extends BaseProfile
{
    /**
     * Se obtiene la ruta hacia el avatar del usuario, si no tiene se le
     * da un avatar por defecto
     * @return String_ ruta hacia el avatar
     */
    public function getAvatar()
    {
        $uploads = Yii::getAlias('@uploads');
        $ruta = "$uploads/{$this->user_id}.jpg";
        return file_exists($ruta) ? "/$ruta" : "/$uploads/default.jpg";
    }

    /**
     * Se obtiene la ruta hacia el avatar del usuario, si no tiene se le
     * da un avatar por defecto
     * @return String_ ruta hacia el avatar
     */
    // public function getAvatarMini()
    // {
    //     $uploads = Yii::getAlias('@uploads');
    //     $ruta = "$uploads/{$this->user_id}-mini.jpg";
    //     return file_exists($ruta) ? "/$ruta" : "/$uploads/default-mini.jpg";
    // }
}
