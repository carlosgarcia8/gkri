<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\commands;

use app\models\User;
use yii\console\Controller;

/**
 * Acciones relacionadas con el mantenimiento del sistema.
 *
 * @author Juan Carlos Garcia <gjcarlos8@gmail.com>
 * @since 0.1
 */
class LimpiarController extends Controller
{
    /**
     * Limpia del sistema los usuarios que no se han activado en el plazo
     * necesario
     */
    public function actionIndex()
    {
        echo User::deleteAll(['and', 'confirmed_at is null', ['>', '(current_timestamp - to_timestamp(created_at))', '48 hours']]);
    }
}
