<?php

namespace app\models;

use Yii;
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
     * Obtiene los posts que estan votados positivos
     * @return \yii\db\ActiveQuery
     */
    public function getPostsVotadosPositivos()
    {
        return $this->getPostsVotados()->joinWith('votos')->where(['positivo' => true, 'votos.usuario_id' => $this->id])->orderBy('created_at desc');
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

    /**
     * Obtiene las notificaciones del usuario
     * @return \yii\db\ActiveQuery
     */
    public function getNotificaciones()
    {
        return $this->hasMany(Notificacion::className(), ['user_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Obtiene los follows de los usuarios que estas siguiendo
     * @return \yii\db\ActiveQuery
     */
    public function getSiguiendo()
    {
        return $this->hasMany(Follow::className(), ['user_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * Obtiene los follows de los usuarios que te estan siguiendo
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidores()
    {
        return $this->hasMany(Follow::className(), ['follow_id' => 'id'])->inverseOf('follow');
    }

    /**
     * Obtiene los usuarios que te estan siguiendo
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidoresUser()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->via('seguidores');
    }

    /**
     * Obtiene los mensajes enviados
     * @return \yii\db\ActiveQuery
     */
    public function getEnviados()
    {
        return $this->hasMany(Message::className(), ['user_id' => 'id'])->inverseOf('emisor');
    }

    /**
     * Obtiene los mensajes recibidos
     * @return \yii\db\ActiveQuery
     */
    public function getRecibidos()
    {
        return $this->hasMany(Message::className(), ['receptor_id' => 'id'])->inverseOf('receptor');
    }

    /**
     * Obtiene las conversaciones del usuario
     * @return \yii\db\ActiveQuery
     */
    public function getConversaciones()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
            select user_id, last_message, username from (select user_id, max(created_at) as last_message
            from ((select user_id, created_at from messages where receptor_id=$this->id)
            union (select receptor_id, created_at from messages where user_id=$this->id))
            as foo group by user_id) as f join public.user on f.user_id=public.user.id
            order by last_message desc;");

        return $command->queryAll();
    }
}
