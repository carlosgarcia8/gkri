<?php

namespace app\models;

/**
 * Este es el modelo para la tabla "messages".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $receptor_id
 * @property string $texto
 * @property string $created_at
 *
 * @property User $user
 * @property User $receptor
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'receptor_id', 'texto'], 'required'],
            [['user_id', 'receptor_id'], 'integer'],
            [['created_at'], 'safe'],
            [['texto'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['receptor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receptor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'receptor_id' => 'Receptor ID',
            'texto' => 'Texto',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Obtiene el emisor del mensaje
     * @return \yii\db\ActiveQuery
     */
    public function getEmisor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('enviados');
    }

    /**
     * Obtiene el receptor del mensaje
     * @return \yii\db\ActiveQuery
     */
    public function getReceptor()
    {
        return $this->hasOne(User::className(), ['id' => 'receptor_id'])->inverseOf('recibidos');
    }
}
