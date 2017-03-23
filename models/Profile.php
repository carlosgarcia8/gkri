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
        $uploadsAvatar = Yii::getAlias('@avatar');
        // TODO solo puede ser jpg, habria que cambiarlo
        $fichero = "{$this->user_id}.jpg";
        $ruta = "$uploadsAvatar/{$fichero}";

        $s3 = Yii::$app->get('s3');

        /*
         * Funcionalidad creada para que cuando el fichero no exista localmente
         * lo guarde de tal manera que cuando este guardado en el contenedor
         * se sirva de ese fichero y no tenga que pedirlo mas a amazon s3, de exista
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
