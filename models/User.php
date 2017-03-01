<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getEntradas()
    // {
    //     return $this->hasMany(Entrada::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    // }
    //
    // /**
    //  * Devuelve el avatar del usuario
    //  * @return String_ Ruta hacia el avatar del usuario
    //  */
    // public function getAvatar()
    // {
    //     return $this->profile->getAvatarMini();
    // }
    //
    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getMeneos()
    // {
    //     return $this->hasMany(Meneo::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    // }
    //
    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getMeneadas()
    // {
    //     return $this->hasMany(Entrada::className(), ['id' => 'entrada_id'])->via('meneos');
    // }
}
