<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<article class="item">
    <header><h2><?= Html::a($model->titulo, ['posts/view', 'id' => $model->id]) ?></h2></header>
    <div class="">
        <?= Html::a(Html::img($model->ruta), ['posts/view', 'id' => $model->id]) ?>
    </div>
    <p class="item-p"><span class="votos-total-<?= $model->id ?>"><?= $model->getVotosTotal() ?> votos
    <!-- </span> | 303 comentarios</p> -->
    <div class="item-votes">
        <ul class="btn-vote left">
        <?php if ($model->estaUpvoteado()) : ?>
            <li><a href="javascript:void(0);" class="vote-up voted-up" alt="<?= $model->id ?>"><i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i></a></li>
        <?php else: ?>
            <li><a href="javascript:void(0);" class="vote-up" alt="<?= $model->id ?>"><i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i></a></li>
        <?php endif; ?>

        <?php if ($model->estaDownvoteado()) : ?>
            <li><a href="javascript:void(0);" class="vote-down voted-down" alt="<?= $model->id ?>"><i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i></a></li>
        <?php else: ?>
            <li><a href="javascript:void(0);" class="vote-down" alt="<?= $model->id ?>"><i class="fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i></a></li>
        <?php endif; ?>

            <li><a href="<?= Url::toRoute(['posts/view', 'id' => $model->id]) ?>"><i class="fa fa-comments fa-2x" aria-hidden="true"></i></a></li>
        </ul>
    </div>
</article>
