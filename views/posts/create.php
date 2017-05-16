<?php

use yii\bootstrap\Alert;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $model app\models\Post */
$url = Url::to('/posts/generador');
$js2 = <<<EOT
    $('.button-upload:first-of-type').on('click', function (e) {
        e.preventDefault();

        $('.button-upload').fadeOut('slow', function () {
            $('.post-form').fadeIn('slow').removeClass('template-oculto');
        });
    });

    $('.button-upload.gray').on('click', function (e) {
        e.preventDefault();
        var w = 800;
        var h = 600;

        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);

        var generador = window.open('$url','generador','width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    });
EOT;
$this->registerJs($js2);
$this->title = 'Enviar un Post';
// $this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/upload-post.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
?>
<div class="post-create">
    <?php
    if (Yii::$app->session->getFlash('error')) {
        echo Alert::widget([
            'options' => ['class' => 'alert-danger'],
            'body' => Yii::$app->session->getFlash('error'),
        ]);
    } ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categorias' => $categorias,
    ]) ?>

    <div class="botones-upload">
        <a href="#" class="button-upload">Elegir una imagen del ordenador</a>
        <a href="<?= Url::to('/posts/generador') ?>" target="_blank" class="button-upload gray">Ir al Generador de Memes</a>
    </div>

</div>
