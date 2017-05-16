<?php

namespace app\models;

/**
 * This is the model class for table "follows".
 *
 * @property integer $user_id
 * @property integer $follow_id
 *
 * @property User $userID
 * @property User $followID
 */
class Follow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'follows';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'follow_id'], 'required'],
            [['user_id', 'follow_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['follow_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['follow_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'Id User',
            'follow_id' => 'Id Follow',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->inverseOf('siguiendo');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollow()
    {
        return $this->hasOne(User::className(), ['id' => 'follow_id'])->inverseOf('seguidores');
    }
}
