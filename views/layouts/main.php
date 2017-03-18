<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$this->registerCssFile('@web/css/estilos.css');
AppAsset::register($this);

$this->title = 'GKRI';

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'GKRI',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Login', 'url' => ['/user/security/login'], 'linkOptions' => ['class' => 'blanco'],'visible' => Yii::$app->user->isGuest],
            ['label' => '', 'url' => ['/'], 'linkOptions' => ['class' => 'glyphicon glyphicon-bell bell'], 'visible' => !Yii::$app->user->isGuest],
            Yii::$app->user->isGuest?
            ['label' => 'Registrarse', 'url' => ['/user/register'], 'linkOptions' => ['class' =>'blanco'],'visible' => Yii::$app->user->isGuest]:
            [
                'label' => Html::img(Yii::$app->user->identity->profile->getAvatar(), ['class' => 'img-rounded little']),
                'url' => ['/user/profile/show', 'username' => Yii::$app->user->identity->username],
                'encode' => false,
                'items' => [
                    [
                       'label' => 'Mi Perfil',
                       'url' => ['/u/' . Yii::$app->user->identity->username],
                    ],
                    [
                       'label' => 'Configuración',
                       'url' => ['/settings/profile']
                    ],
                    '<li class="divider"></li>',
                    [
                       'label' => 'Logout',
                       'url' => ['/user/security/logout'],
                       'linkOptions' => ['data-method' => 'post'],
                    ],
                ],
                'linkOptions' => ['id' => 'imagen-avatar'],
            ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; GKRI <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
