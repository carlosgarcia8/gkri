<?php

namespace app\models;

use yii\base\Model;

/**
 * Clase para el formulario de creación del mensaje
 */
class MessageForm extends Model
{
    /**
     * El id del usuario que va a recibir el mensaje
     * @var int
     */
    public $receptor_id;

    /**
     * El texto del mensaje
     * @var string
     */
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
