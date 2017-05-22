<?php

namespace app\models;

use Yii;

/**
 * Este es el modelo para la tabla  "votos_c".
 *
 * @property integer $usuario_id
 * @property integer $comentario_id
 * @property boolean $positivo
 *
 * @property Comment $comentario
 * @property User $usuario
 */
class VotoComentario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'votos_c';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'comentario_id'], 'required'],
            [['usuario_id', 'comentario_id'], 'integer'],
            [['positivo'], 'boolean'],
            [['comentario_id'], 'exist', 'skipOnError' => true, 'targetClass' => CommentModel::className(), 'targetAttribute' => ['comentario_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => Yii::t('app', 'Usuario ID'),
            'comentario_id' => Yii::t('app', 'Comentario ID'),
            'positivo' => Yii::t('app', 'Positivo'),
        ];
    }

    /**
     * Obtiene el comentario
     * @return \yii\db\ActiveQuery
     */
    public function getComentario()
    {
        return $this->hasOne(CommentModel::className(), ['id' => 'comentario_id'])->inverseOf('votos');
    }

    /**
     * Obtiene el usuario
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id'])->inverseOf('votosComentarios');
    }
}
