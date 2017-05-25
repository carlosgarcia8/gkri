<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->registerJsFile('@web/js/gifs.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->registerJsFile('@web/js/votar.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->registerJsFile('@web/js/votar-comentarios.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($esAdmin) : ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Seguro que deseas eliminar este Post?',
                'method' => 'post',
            ],
        ]) ?>
    </p><?php endif; ?>

    <article class="item item-post-<?= $model->id ?>">
        <header><h2><?= Html::a($model->titulo, ['/posts/view', 'id' => $model->id]) ?></h2></header>
        <div class="">
            <p class="item-p">
                <span  class="votos-total-<?= $model->id ?>"><?= $model->getVotosTotal() ?> votos</span> | <span  id="count-comment-total"><?= $model->getNumeroComentarios() ?> comentarios</span> | Categoría: <?= $model->categoria->nombre ?>
            </p>
            <div class="item-votes">
                <ul class="btn-vote left">
                <?php if ($model->estaUpvoteado()) : ?>
                    <li><a href="javascript:void(0);" class="vote-up voted-up" data-id="<?= $model->id ?>"><span class="fa fa-thumbs-up fa-2x" aria-hidden="true"></span></a></li>
                <?php else: ?>
                    <li><a href="javascript:void(0);" class="vote-up" data-id="<?= $model->id ?>"><span class="fa fa-thumbs-up fa-2x" aria-hidden="true"></span></a></li>
                <?php endif; ?>

                <?php if ($model->estaDownvoteado()) : ?>
                    <li><a href="javascript:void(0);" class="vote-down voted-down" data-id="<?= $model->id ?>"><span class="fa fa-thumbs-down fa-2x" aria-hidden="true"></span></a></li>
                <?php else: ?>
                    <li><a href="javascript:void(0);" class="vote-down" data-id="<?= $model->id ?>"><span class="fa fa-thumbs-down fa-2x" aria-hidden="true"></span></a></li>
                <?php endif; ?>
                </ul>
                <div class="">
                    Enviado por <?= Html::a($autor->username, ['/u/' . $autor->username]) ?> el <?= Yii::$app->formatter->asDate($model->fecha_publicacion, 'php:d M Y') ?>
                </div>
            </div>
        </div>
        <div class="item-imagen">
            <?php if ($model->extension == 'gif') : ?>
                <video width="455" loop="loop" autoplay="autoplay">
                    <source src="<?= $model->ruta ?>" type="video/mp4">
                </video>
                <ins class="play-gif" style="display:none; top: 40%; left: 32%;">GIF</ins>
            <?php else : ?>
                <?= Html::img($model->ruta . '?t=' . date('d-m-Y-H:i:s'), ['class' => 'responsive-image', 'alt'=> $model->ruta]) ?>
            <?php endif; ?>
        </div>
        <?php if ($esAutor && !$esAdmin) : ?>
        <div class="text-right">
            <p >
                <?= Html::a('DELETE', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-link',
                    'data' => [
                        'confirm' => '¿Estás seguro de eliminar este Post?',
                        'method' => 'post',
                    ],
                ]) ?>
                </p>
        </div><?php endif; ?>
        <div class="" id="comments"></div>
    </article>
    <div class="">
        <?php echo \yii2mod\comments\widgets\Comment::widget([
            'model' => $model,
            'commentView' => '@app/views/comments/index',
            'maxLevel' => 2,
        ]); ?>
    </div>
</div>
<?php
$this->registerJs(
    "
    $(document).on('click', '.comment-vote-up', function() {
        votarComentario($(this).attr('data-comment-id'), true);
    });

    $(document).on('click', '.comment-vote-down', function() {
        votarComentario($(this).attr('data-comment-id'), false);
    });

    $(document).on('afterReply', '#comment-form', function (e) {
        $('#cancel-reply').on('click', function() {
            $('#commentmodel-content').val('');
        });
    });

    $(document).on('beforeReply', '#comment-form', function (e) {
        var id = e.delegateTarget.activeElement.attributes[3].value;
        var username = $('#comment-list-' + id).find('img').attr('alt');
        $('#commentmodel-content').val('@' + username + ' ');
    });
     ",
    \yii\web\View::POS_READY,
    'custom-js'
);
?>
