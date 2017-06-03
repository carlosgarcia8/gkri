<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $model app\models\Post */
$url = Url::to('/posts/generador');
$js2 = <<<EOT
    $('.button-upload:last-of-type').on('click', function (e) {
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
$this->registerJsFile('@web/js/upload-post.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
?>
<div class="modal fade post-create" id="modal-upload" tabindex="-1" role="dialog"
     aria-labelledby="modal-upload" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Cerrar</span>
                </button>
                <h2 class="modal-title text-center">
                    <?= $this->title ?>
                </h2>
            </div>
            <div class="modal-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'categorias' => $categorias,
                ]) ?>
                <h3>Rellena el formulario anterior o bien puedes...</h3>
                <div class="botones-upload">
                    <a href="<?= Url::to('/posts/generador') ?>" target="_blank" class="button-upload">Ir al Generador de Memes</a>
                </div>
            </div>
        </div>
    </div>
</div>
