<?php

namespace app\models;

use app\models\CommentModel;
use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    /**
     * Obtiene los posts que ha creado el usuario
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Obtiene la ruta del avatar del usuario
     * @return string
     */
    public function getAvatar()
    {
        return $this->profile->getAvatar();
    }

    /**
     * Obtiene el nombre de usuario
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Obtiene los posts moderador por el usuario
     * @return \yii\db\ActiveQuery
     */
    public function getModeraciones()
    {
        return $this->hasMany(Post::className(), ['moderated_by' => 'id'])->inverseOf('moderadoPor');
    }

    /**
     * Obtiene los posts pendientes
     * @return \yii\db\ActiveQuery
     */
    public function getPostPendiente()
    {
        return $this->getPosts()->pending()->all();
    }

    /**
     * Obtiene los posts aprobados
     * @return \yii\db\ActiveQuery
     */
    public function getPostsAceptados()
    {
        return $this->getPosts()->approved()->all();
    }

    /**
     * Obtiene los votos realizados sobre los posts
     * @return \yii\db\ActiveQuery
     */
    public function getVotos()
    {
        return $this->hasMany(Voto::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Obtiene los posts votados
     * @return \yii\db\ActiveQuery
     */
    public function getPostsVotados()
    {
        return $this->hasMany(Post::className(), ['id' => 'post_id'])->via('votos');
    }

    /**
     * Obtiene los votos sobre los comentarios
     * @return \yii\db\ActiveQuery
     */
    public function getVotosComentarios()
    {
        return $this->hasMany(VotoComentario::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Obtiene los comentarios que ha votado el usuario
     * @return \yii\db\ActiveQuery
     */
    public function getComentariosVotados()
    {
        return $this->hasMany(CommentModel::className(), ['id' => 'comentario_id'])->via('votosComentarios');
    }

    /**
     * Obtiene los comentarios que ha creado el usuario
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(CommentModel::className(), ['createdBy' => 'id'])->inverseOf('usuario');
    }
}
