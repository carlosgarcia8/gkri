<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

// TODO los comentarios arriba del post no se actualizan

$this->registerJsFile('@web/js/votar.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
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
        <header><h2><?= Html::a($model->titulo, ['posts/view', 'id' => $model->id]) ?></h2></header>
        <div class="">
            <p class="item-p">
                <span class="votos-total-<?= $model->id ?>"><?= $model->getVotosTotal() ?> votos</span> | <?= $model->getNumeroComentarios() ?> comentarios | Categoría: <?= $model->categoria->nombre ?>
            </p>
            <div class="item-votes">
                <ul class="btn-vote left">
                <?php if ($model->estaUpvoteado()) : ?>
                    <li><a href="javascript:void(0);" class="vote-up voted-up" data-id="<?= $model->id ?>"><i class="fa fa-thumbs-up fa-2x" aria-hidden="true"></i></a></li>
                <?php else: ?>
                    <li><a href="javascript:void(0);" class="vote-up" data-id="<?= $model->id ?>"><i class="fa fa-thumbs-up fa-2x" aria-hidden="true"></i></a></li>
                <?php endif; ?>

                <?php if ($model->estaDownvoteado()) : ?>
                    <li><a href="javascript:void(0);" class="vote-down voted-down" data-id="<?= $model->id ?>"><i class="fa fa-thumbs-down fa-2x" aria-hidden="true"></i></a></li>
                <?php else: ?>
                    <li><a href="javascript:void(0);" class="vote-down" data-id="<?= $model->id ?>"><i class="fa fa-thumbs-down fa-2x" aria-hidden="true"></i></a></li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="item-imagen">
            <?= Html::img($model->ruta) ?>
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
