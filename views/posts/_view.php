<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<article class="item item-post-<?= $model->id ?>">
    <header><h2><?= Html::a($model->titulo, ['/posts/view', 'id' => $model->id]) ?></h2></header>
    <div class="">
    <?php if ($model->extension == 'gif') : ?>
        <video width="455" loop="loop" autoplay="autoplay">
            <source src="<?= $model->ruta ?>" type="video/mp4">
        </video>
    <?php else : ?>
        <?= Html::a(Html::img($model->ruta), ['/posts/view', 'id' => $model->id]) ?>
    <?php endif; ?>
    </div>
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

            <li><a href="<?= Url::toRoute(['/posts/view', 'id' => $model->id, '#' => 'comments']) ?>"><i class="fa fa-comments fa-2x" aria-hidden="true"></i></a></li>
        </ul>
    </div>
</article>
