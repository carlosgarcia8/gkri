<?php
use yii\helpers\Url;
use yii\helpers\Html;

if ($model->getRuta() !== false) :

if ($model->extension == 'gif') : ?>
<div class="viewport"></div>
<?php endif; ?>

<article class="item item-post-<?= $model->id ?>" <?php if ($index === 0) : ?>
    data-step="5" data-position="right" data-intro="Esto es un post. Arriba verás el título y debajo
    podrás darle voto positivo o negativo, siempre y cuando hayas iniciado sesión. Para ver los comentarios
    solo tienes que hacer clic en la imagen o en el título. Eso es todo. Espero que disfrutes de tu paso por GKRI. :D" <?php endif; ?>
    itemscope itemtype="http://schema.org/CreativeWork">
    <header><h2 itemprop="about"><?= Html::a($model->titulo, ['/posts/view', 'id' => $model->id]) ?></h2></header>
    <?php if ($model->extension == 'gif') : ?>
    <div class="gifplayer-wrapper">
        <video width="455" loop="loop" itemprop="video">
            <source src="<?= $model->ruta . '?t=' . date('d-m-Y-H:i:s') ?>" type="video/mp4">
        </video>
        <ins class="play-gif" style="display:none; top: 43%; left: 43%;">GIF</ins>
    </div>
    <?php else : ?>
    <div class="" itemprop="image">
        <?= Html::a(Html::img($model->ruta . '?t=' . date('d-m-Y-H:i:s'), ['class' => 'responsive-image', 'alt'=> $model->ruta, 'itemprop' => 'image']), ['/posts/view', 'id' => $model->id]) ?>
    </div>
    <div class="template-oculto">
        <div class="" itemprop="author" itemscope itemtype="http://schema.org/Person">
            <span itemprop="additionalName"><?= $model->usuario_id ?></span>
        </div>
    </div>
    <?php endif; ?>
    <p class="item-p">
        <span class="votos-total-<?= $model->id ?>"><?= $model->getVotosTotal() ?> votos</span> | <span itemprop="commentCount"><?= $model->getNumeroComentarios() ?> comentarios </span itemprop="genre">| Categoría: <?= $model->categoria->nombre ?>
    </p>
    <div class="item-votes">
        <ul class="btn-vote left">
        <?php if ($model->estaUpvoteado()) : ?>
            <li><a href="" class="vote-up voted-up" data-id="<?= $model->id ?>"><span class="fa fa-thumbs-up fa-2x" aria-hidden="true"></span></a></li>
        <?php else: ?>
            <li><a href="" class="vote-up" data-id="<?= $model->id ?>"><span class="fa fa-thumbs-up fa-2x" aria-hidden="true"></span></a></li>
        <?php endif; ?>

        <?php if ($model->estaDownvoteado()) : ?>
            <li><a href="" class="vote-down voted-down" data-id="<?= $model->id ?>"><span class="fa fa-thumbs-down fa-2x" aria-hidden="true"></span></a></li>
        <?php else: ?>
            <li><a href="" class="vote-down" data-id="<?= $model->id ?>"><span class="fa fa-thumbs-down fa-2x" aria-hidden="true"></span></a></li>
        <?php endif; ?>

            <li><a href="<?= Url::toRoute(['/posts/view', 'id' => $model->id, '#' => 'comments']) ?>"><span class="fa fa-comments fa-2x" aria-hidden="true"></span></a></li>
        </ul>
    </div>
</article>
<?php endif; ?>
