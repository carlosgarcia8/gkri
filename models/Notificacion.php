<?php

namespace app\models;

use app\models\enums\NotificationType;

/**
 * This is the model class for table "notificaciones".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $user_id
 * @property boolean $seen
 * @property string $created_at
 * @property string $url
 *
 * @property User $user
 */
class Notificacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notificaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type', 'user_id'], 'integer'],
            [['type'], 'in', 'range' => NotificationType::getConstantsByName()],
            [['seen'], 'boolean'],
            [['created_at', 'url'], 'safe'],
            [['url'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'user_id' => 'User ID',
            'seen' => 'Seen',
            'created_at' => 'Created At',
            'url' => 'Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('notificaciones');
    }
}
