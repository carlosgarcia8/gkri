<?php

namespace app\models;

use yii\base\Model;

class MessageForm extends Model
{
    public $receptor_id;

    public $texto;

    public function rules()
    {
        return [
            [['receptor_id'],'integer'],
            [['texto', 'receptor_id'],'required'],
            [['texto'], 'string', 'max' => 255],
        ];
    }
}
