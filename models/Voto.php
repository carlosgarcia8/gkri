<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "votos".
 *
 * @property integer $usuario_id
 * @property integer $post_id
 * @property boolean $positivo
 *
 * @property Posts $post
 * @property User $usuario
 */
class Voto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'votos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'post_id'], 'required'],
            [['usuario_id', 'post_id'], 'integer'],
            [['positivo'], 'boolean'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => 'Usuario ID',
            'post_id' => 'Post ID',
            'positivo' => 'Positivo',
        ];
    }

    /**
     * Obtiene el post
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id'])->inverseOf('votos');
    }

    /**
     * Obtiene el usuario
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id'])->inverseOf('votos');
    }
}
