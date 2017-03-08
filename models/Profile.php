<?php

namespace app\models;

use dektrium\user\models\Profile as BaseProfile;
use Yii;

class Profile extends BaseProfile
{
    /**
     * Se obtiene la ruta hacia el avatar del usuario, si no tiene se le
     * da un avatar por defecto
     * @return string ruta hacia el avatar
     */
    public function getAvatar()
    {
        $uploads = Yii::getAlias('@uploads');
        $fichero = "{$this->user_id}.jpg";
        $rutaLocal = "$uploads/{$fichero}";

        $s3 = Yii::$app->get('s3');

        /*
         * Funcionalidad creada para que cuando el fichero no exista localmente
         * lo guarde de tal manera que cuando este guardado en el contenedor
         * se sirva de ese fichero y no tenga que pedirlo mas a amazon s3, de exista
         * manera ganamos eficiencia.
         */
        if (file_exists($rutaLocal)) {
            return "/$rutaLocal";
        } elseif ($s3->exist($fichero)) {
            $s3->commands()->get($fichero)->saveAs($rutaLocal)->execute();
            return "/$rutaLocal";
        } else {
            return "/$uploads/default.jpg";
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
