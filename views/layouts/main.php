<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Categoria;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$url = Url::to(['/posts/search-ajax']);
$js = <<<EOT
    $('#search').on('keyup', function () {
        $('#lupa').removeClass('glyphicon-refresh glyphicon-refresh-animate').addClass('glyphicon-search');

        if ($('#search').val().length >= 2) {
            $('#lupa').removeClass('glyphicon-search').addClass('glyphicon-refresh glyphicon-refresh-animate');
        }
        
        $('#search').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    method: 'get',
                    url: '$url',
                    data: {
                        q: $('#search').val()
                    },
                    success: function (data, status, event) {
                        $('#lupa').removeClass('glyphicon-refresh glyphicon-refresh-animate').addClass('glyphicon-search');
                        var d = JSON.parse(data);
                        response(d);
                    }
                });
            },
            minLength: 2,
            delay: 800,
            // search: function(event, ui) {
            //
            // },
            response: function(event, ui) {
                $('#lupa').removeClass('glyphicon-refresh glyphicon-refresh-animate').addClass('glyphicon-search');
            }
        }).data("ui-autocomplete")._renderItem = function( ul, item ) {
            return $( "<li>" )
            .attr( "data-value", item.value )
            .append( $( "<a>" ).html( item.label.replace(new RegExp('^' + this.term, 'gi'),"<strong>$&</strong>") ) )
            .appendTo( ul );
        }

    });
EOT;

$this->registerCssFile('@web/css/estilos.css');
AppAsset::register($this);
$this->registerJs($js);
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
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <script src="https://use.fontawesome.com/a727822b2c.js"></script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logo.png', ['alt'=>Yii::$app->name, 'class' => 'logo']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    ?>
    <ul class="navbar-nav navbar-left nav">
        <li><a href="/gracioso">Gracioso</a></li>
        <li><a href="/amor">Amor</a></li>
        <li><a href="/series">Series</a></li>
        <li><a href="/wtf">WTF</a></li>
        <li class="dropdown">
            <a href="/" data-toggle="dropdown" class="dropdown-toggle">Más<b class="caret"></b></a>
            <ul class="dropdown-menu multi-column columns-3">
                <div class="row">
                    <?php foreach ($categorias as $i => $categoria) {
                        if ($i == 0) { ?>
                            <div class="col-sm-4">
                                <ul class="multi-column-dropdown">
                                    <li><a href="/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                        <?php }
                        elseif ($i == 5 || $i == 11) { ?>
                                    <li><a href="/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <ul class="multi-column-dropdown">
                        <?php
                        } elseif ($i == count($categorias) - 1) { ?>
                                    <li><a href="/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
                                </ul>
                            </div>
                        <?php
                        } else { ?>
                            <li><a href="/<?= $categoria->nombre_c ?>"><?= $categoria->nombre ?></a></li>
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
    ]);?>

    <div class="input-group">
        <div class="input-group-btn"><?php
            $form = ActiveForm::begin(['action' =>  ['/posts/search'], 'method' => 'get', 'options' => ['class' => 'navbar-form navbar-right','role' => 'search']]);?>
               <input type="text" id="search" class="form-control" placeholder="Search" name="q">
               <button class="btn btn-default lupa" type="submit"><i id="lupa" class="glyphicon glyphicon-search"></i></button>
               <div class="sugerenciasa"></div>
            <?php ActiveForm::end();?>
        </div>
   </div><?php

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
