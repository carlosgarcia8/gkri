<?php

namespace app\models\enums;

use yii2mod\enum\helpers\BaseEnum;

/**
 * Clase de la que hereda Notification
 */
class NotificationType extends BaseEnum
{
    /**
     * POST DEL USUARIO ACEPTADO
     * @var int
     */
    const POST_ACEPTADO = 0;

    /**
     * POST DEL USUARIO VOTADO
     * @var int
     */
    const VOTADO = 1;

    /**
     * POST DEL USUARIO COMENTADO
     * @var int
     */
    const COMENTADO = 2;

    /**
     * SEGUIDOR NUEVO
     * @var int
     */
    const SEGUIDOR_NUEVO = 3;

    /**
     * POST NUEVO DE UN USUARIO QUE SIGUES
     * @var int
     */
    const POST_NUEVO = 4;

    /**
     * REPLY A UN COMENTARIO HECHO POR EL USUARIO
     * @var int
     */
    const REPLY = 5;

    /**
     * MENSAJE NUEVO
     * @var int
     */
    const MENSAJE_NUEVO = 6;

    /**
     * POST RECHAZADO
     * @var int
     */
    const POST_RECHAZADO = 7;

    /**
     * Lista de las constantes con su texto
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
        self::POST_RECHAZADO => 'Post Rechazado',
    ];
}
