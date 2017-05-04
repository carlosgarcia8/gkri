<?php

namespace app\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class NotificationType extends BaseEnum
{
    const POST_ACEPTADO = 0;
    const VOTADO = 1;
    const COMENTADO = 2;

    /**
     * @var array
     */
    public static $list = [
        self::POST_ACEPTADO => 'Post Aceptado',
        self::VOTADO => 'Votado',
        self::COMENTADO => 'Comentado',
    ];
}
