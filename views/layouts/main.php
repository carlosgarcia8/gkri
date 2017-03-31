<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Categoria;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$this->registerCssFile('@web/css/estilos.css');
AppAsset::register($this);
$categorias = Categoria::find()->all();
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
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina" rel="stylesheet">
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

    ?>
    <ul class="navbar-nav navbar-left nav">
        <li><a href="/posts/gracioso">Gracioso</a></li>
        <li><a href="/posts/amor">Amor</a></li>
        <li><a href="/posts/series">Series</a></li>
        <li><a href="/posts/wtf">WTF</a></li>
        <li class="dropdown">
            <a href="/" data-toggle="dropdown" class="dropdown-toggle">Más<b class="caret"></b></a>
            <ul class="dropdown-menu multi-column columns-3">
                <div class="row">
                    <?php foreach ($categorias as $i => $categoria) {
                        if ($i == 0) { ?>
                            <div class="col-sm-4">
                                <ul class="multi-column-dropdown">
                                    <li><a href="/posts/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                        <?php }
                        elseif ($i == 5 || $i == 11) { ?>
                                    <li><a href="/posts/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <ul class="multi-column-dropdown">
                        <?php
                        } elseif ($i == count($categorias) - 1) { ?>
                                    <li><a href="/posts/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                                </ul>
                            </div>
                        <?php
                        } else { ?>
                            <li><a href="/posts/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                        <?php }
                    } ?>
                </div>
            </ul>
        </li>
    </ul>
    <?php

    // echo Nav::widget([
    //     'options' => ['class' => 'navbar-nav navbar-left'],
    //     'items' => [
    //         ['label' => 'Gracioso', 'url' => ['/posts/gracioso'], 'linkOptions' => ['class' => 'categoria']],
    //         ['label' => 'Amor', 'url' => ['/posts/amor'], 'linkOptions' => ['class' => 'categoria']],
    //         ['label' => 'Series', 'url' => ['/posts/series'], 'linkOptions' => ['class' => 'categoria']],
    //         ['label' => 'WTF', 'url' => ['/posts/wtf'], 'linkOptions' => ['class' => 'categoria']],
    //         [
    //         'label' => 'Más',
    //         'url' => '/',
    //         'items' => [
    //             ['label' => 'Level 1 - Dropdown A', 'url' => ''],
    //             ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
    //         ],
    //     ],
    //     ],
    // ]);
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
            ['label' => 'Upload', 'url' => ['/posts/upload'], 'linkOptions' => ['class' => 'boton-upload btn-primary'], 'visible' => !Yii::$app->user->isGuest],
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
