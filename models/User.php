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

    public function getAvatar()
    {
        return $this->profile->getAvatar();
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModeraciones()
    {
        return $this->hasMany(Post::className(), ['moderated_by' => 'id'])->inverseOf('moderadoPor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostPendiente()
    {
        return $this->getPosts()->pending()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostsAceptados()
    {
        return $this->getPosts()->approved()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotos()
    {
        return $this->hasMany(Voto::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostsVotados()
    {
        return $this->hasMany(Post::className(), ['id' => 'post_id'])->via('votos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotosComentarios()
    {
        return $this->hasMany(VotoComentario::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
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
