<?php

namespace app\models;

use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModeraciones()
    {
        return $this->hasMany(Post::className(), ['moderated_by' => 'id'])->inverseOf('moderadoPor');
    }

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
