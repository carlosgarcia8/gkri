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
        $fichero = "{$this->user_id}.jpg";
        $rutaLocal = "$uploads/{$fichero}";

        $s3 = Yii::$app->get('s3');

        if (!$s3->exist($fichero)) {
            return file_exists($rutaLocal) ? "/$rutaLocal" : "/$uploads/default.jpg";
        } else {
            return $s3->get($fichero)['@metadata']['effectiveUri'];
        }
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
