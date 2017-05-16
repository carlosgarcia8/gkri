<?php

namespace app\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class NotificationType extends BaseEnum
{
    const POST_ACEPTADO = 0;
    const VOTADO = 1;
    const COMENTADO = 2;
    const SEGUIDOR_NUEVO = 3;
    const POST_NUEVO = 4;
    const REPLY = 5;
    const MENSAJE_NUEVO = 6;

    /**
     * @var array
     */
    public static $list = [
        self::POST_ACEPTADO => 'Post Aceptado',
        self::VOTADO => 'Votado',
        self::COMENTADO => 'Comentado',
        self::SEGUIDOR_NUEVO => 'Seguidor Nuevo',
        self::POST_NUEVO => 'Post Nuevo',
        self::REPLY => 'Reply',
        self::MENSAJE_NUEVO => 'Mensaje Nuevo',
    ];
}
