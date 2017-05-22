<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Asset para añadir css, js y dependencias de otros assets
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/estilos.css',
        'css/bootstrap-notifications.css',
        'css/bootstrap-notifications.min.css',
        'css/introjs.css',
        'css/introjs-modern.css',
    ];
    public $js = [
        'js/script.js',
        'js/isInViewport.js',
        'js/intro.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\jui\JuiAsset',
    ];
}
