<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Post;
use app\models\User;
use app\models\Categoria;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\CommentModel;

// TODO reply a los replies

AppAsset::register($this);
$this->registerJsFile('@web/js/autocompletar.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
if (!Yii::$app->user->isGuest) {
    $this->registerJsFile('@web/js/notificaciones.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
    $this->registerJsFile('@web/js/mensajes.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);

    $user = User::findOne(['id' => Yii::$app->user->id]);

    $conversaciones = $user->getConversaciones();
}
$model = new Post(['scenario' => Post::SCENARIO_UPLOAD]);
$categoriasPost = Categoria::find()->select('nombre')->indexBy('id')->column();

$js = <<<EOT
    var tour = localStorage.getItem('tour');

    if (tour === null) {
        if (location.pathname !== '/') {
            location.pathname = '/';
        } else {
            introJs()
            .setOption('showStepNumbers', false)
            .setOption('nextLabel', 'Siguiente')
            .setOption('prevLabel', 'Anterior')
            .setOption('skipLabel', 'Terminar Tour')
            .setOption('doneLabel', 'Terminar Tour')
            .setOption('overlayOpacity', 0.2)
            .start();
            localStorage.setItem('tour', 1);
        }
    }

    var cookieBanner = localStorage.getItem('cookie-banner');

    if (cookieBanner === null) {
        $('.wrap').append('<div class="banner-cookie"></div>');
        $('.banner-cookie').append('<p>Esta página web usa cookies para asegurarse de que obtienes la mejor experiencia en nuestra aplicación.</p>');
        $('.banner-cookie').append('<button type="button" class="banner-cookie-btn">Entendido</button>');
    }

    $('.navbar-left a, .categorias-sub a').each(function(index, value) {
        if ($(this).prop("href") === window.location.href) {
            $(this).parent().addClass('active');
        }
    });

    $('.banner-cookie-btn').on('click', function() {
        $('.banner-cookie').fadeOut('fast');
        localStorage.setItem('cookie-banner', 1);
    });
EOT;
$this->registerJs($js);
$categorias = Categoria::find()->all();
CommentModel::deleteAll(['status' => 2]);
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
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <script src="https://use.fontawesome.com/a727822b2c.js"></script>
</head>
<body>
<div class="template-oculto">
    <div class="msg">
        <div class="msg-body">
            <div class="msg-avatar-receptor">

            </div>
            <div class="msg-resto">
                <div class="msg-header">
                    <small class="text-muted">
                        <span class="glyphicon glyphicon-time"></span>
                    </small>
                </div>
                <p></p>
            </div>
            <div class="msg-avatar-emisor">

            </div>
        </div>
    </div>
</div>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logo.png', [
            'alt'=>Yii::$app->name,
            'class' => 'logo',
            'data-intro'=>"¡Bienvenido! Vamos a hacer un pequeño Tour para que no te pierdas ni un detalle.",
            'data-step'=>"1"
        ]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top menu-grande',
        ],
    ]);

    ?>
    <ul class="navbar-nav navbar-left nav" data-step="2" data-intro="Aquí están las distintas categorías, selecciona la que más te guste y empieza a divertirte.">
        <li><a href="/gracioso">Gracioso</a></li>
        <li><a href="/amor">Amor</a></li>
        <li><a href="/series">Series</a></li>
        <li><a href="/wtf">WTF</a></li>
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle">Más<em class="caret"></em></a>
            <ul class="dropdown-menu multi-column columns-3">
            <?php foreach ($categorias as $i => $categoria) {
                if ($i == 0) { ?>
                    <li class="col-sm-4 col-xs-4">
                        <ul class="multi-column-dropdown">
                            <li><a href="/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                <?php }
                elseif ($i == 5 || $i == 11) { ?>
                            <li><a href="/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                        </ul>
                    </li>
                    <li class="col-sm-4 col-xs-4">
                        <ul class="multi-column-dropdown">
                <?php
                } elseif ($i == count($categorias) - 1) { ?>
                            <li><a href="/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                        </ul>
                    </li>
                <?php
                } else { ?>
                    <li><a href="/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                <?php }
            } ?>
            </ul>
        </li>
    </ul>
    <div class="dropdown sub-menu categorias-sub">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="fa fa-bars" aria-hidden="true" title="Categorías"></span>
        </button>
        <ul class="dropdown-menu">
            <?php foreach ($categorias as $i => $categoria) : ?>
            <li><a href="/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
   <ul class="navbar-nav navbar-right nav" data-step="3" data-intro="Aquí tendrás las distintas opciones del usuario cuando hayas iniciado sesión, como ver tu perfil, las notificaciones o incluso ¡subir tu propio post!">
       <li></li>
       <li class="dropdown dropdown-search">
           <a data-toggle="dropdown" class="dropdown-toggle"><span id="lupa" class="glyphicon glyphicon-search" title="Buscador"></span></a>
           <ul class="dropdown-menu dropdown-menu-search">
               <li>
                   <?php ActiveForm::begin(['action' =>  ['/posts/search'], 'method' => 'get', 'options' => ['class' => 'navbar-form navbar-right','role' => 'search']]);?>
                   <label for="search" style="display:none;">Buscar</label>
                   <input type="text" id="search" class="form-control" maxlength="100" placeholder="Search" name="q">
                   <?php ActiveForm::end();?>
               </li>
           </ul>
       </li>
    <?php if (Yii::$app->user->isGuest) : ?>
        <li><a class="blanco" href="<?= Url::to('/user/security/login') ?>">Login</a></li>
        <li><a class="blanco" href="<?= Url::to('/user/register') ?>">Registrarse</a></li>
    <?php else :?>
        <li class="dropdown dropdown-notifications">
            <a data-toggle="dropdown" class="dropdown-toggle">
              <span data-count="0" class="glyphicon glyphicon-bell notification-icon hidden-icon" title="Notificaciones"></span>
            </a>

            <div class="dropdown-container">

                <div class="dropdown-toolbar">
                    <div class="dropdown-toolbar-actions">
                        <a href="/" id="notification-all-read">Marcar todas como leídas</a>
                    </div>
                    <h3 class="dropdown-toolbar-title">Notificaciones</h3>
                </div>

                <ul class="dropdown-menu dropdown-notifications-list">

                </ul>
            </div>
        </li>
        <li class="dropdown">
            <a id="imagen-avatar" class="dropdown-toggle" href="/u/xharly8" data-toggle="dropdown">
                <?= Html::img(Yii::$app->user->identity->profile->getAvatar() . '?t=' . date('d-m-Y-H:i:s'), ['class' => 'img-rounded little']) ?>
                <em class="caret"></em>
            </a>
            <ul class="dropdown-menu">
                <li><a href="<?= Url::to('/u/' . Yii::$app->user->identity->username) ?> " tabindex="-1">Mi Perfil</a></li>
                <li><a href="<?= Url::to('/settings/profile') ?>" tabindex="-1">Configuración</a></li>
                <li><a href="#" data-toggle="modal" data-target="#messages" tabindex="-1">Mensajes</a></li>
                <li class="divider"></li>
                <li><a href="<?= Url::to('/user/security/logout') ?>" data-method="post" tabindex="-1">Cerrar sesión</a></li>
            </ul>
        </li>
        <li class="sub-menu"><a href="<?= Url::to('/u/' . Yii::$app->user->identity->username) ?> "><span class="fa fa-user" aria-hidden="true" title="Mi Perfil"></span></a></li>
        <li class="sub-menu"><a href="<?= Url::to('/settings/profile') ?>"><span class="fa fa-cog" aria-hidden="true" title="Configuración"></span></a></li>
        <li class="sub-menu"><a href="#" data-toggle="modal" data-target="#messages"><span class="fa fa-envelope" aria-hidden="true" title="Mensajes"></span></a></li>
        <li class="sub-menu"><a href="<?= Url::to('/user/security/logout') ?>" data-method="post"><span class="fa fa-sign-out" aria-hidden="true" title="Cerrar sesión"></span></a></li>
        <li class="sub-menu sub-menu-upload"><a class="boton-upload btn-primary" href="" data-toggle="modal" data-target="#modal-upload"><span class="fa fa-upload" aria-hidden="true" title="Upload"></span></a></li>
        <li class="sub-menu-noupload"><a class="boton-upload btn-primary" href="" data-toggle="modal" data-target="#modal-upload">Enviar</a></li>
    <?php endif; ?>
    </ul> <?php

    NavBar::end();

    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php if (isset($conversaciones)) : ?>
        <?= $this->render('messages', ['conversaciones' => $conversaciones, 'user' => $user]) ?>
        <?php endif; ?>
        <?= $this->render('../posts/create', ['model' => $model, 'categorias' => $categoriasPost]) ?>
        <?= $content ?>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; GKRI <?= date('Y') ?></p>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
