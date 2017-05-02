<?php
use yii\helpers\Url;
use yii\helpers\Html;

$post = \app\models\Post::findOne(['id' => $model->entityId]);

?>
<h5><?= $profile->user->username ?> <?= Html::a('commented', ['/posts/' . $post->id . '#comment-list-' . $model->id]) ?></h5>
<article class="item item-post-<?= $post->id ?>">
    <header><h2><?= Html::a($post->titulo, ['/posts/view', 'id' => $post->id]) ?></h2></header>
    <div class="">
        <?php if ($post->extension == 'gif') : ?>
            <video width="455" height="240" loop="loop" autoplay="autoplay">
                <source src="<?= $post->ruta ?>" type="video/mp4">
            </video>
        <?php else : ?>
            <?= Html::a(Html::img($post->ruta), ['/posts/view', 'id' => $post->id]) ?>
        <?php endif; ?>
    </div>
    <p class="item-p">
        <span class="votos-total-<?= $post->id ?>"><?= $post->getVotosTotal() ?> votos</span> | <?= $post->getNumeroComentarios() ?> comentarios | Categoría: <?= $post->categoria->nombre ?>
    </p>
    <div class="item-votes">
        <ul class="btn-vote left">
        <?php if ($post->estaUpvoteado()) : ?>
            <li><a href="javascript:void(0);" class="vote-up voted-up" data-id="<?= $post->id ?>"><i class="fa fa-thumbs-up fa-2x" aria-hidden="true"></i></a></li>
        <?php else: ?>
            <li><a href="javascript:void(0);" class="vote-up" data-id="<?= $post->id ?>"><i class="fa fa-thumbs-up fa-2x" aria-hidden="true"></i></a></li>
        <?php endif; ?>

        <?php if ($post->estaDownvoteado()) : ?>
            <li><a href="javascript:void(0);" class="vote-down voted-down" data-id="<?= $post->id ?>"><i class="fa fa-thumbs-down fa-2x" aria-hidden="true"></i></a></li>
        <?php else: ?>
            <li><a href="javascript:void(0);" class="vote-down" data-id="<?= $post->id ?>"><i class="fa fa-thumbs-down fa-2x" aria-hidden="true"></i></a></li>
        <?php endif; ?>

            <li><a href="<?= Url::toRoute(['/posts/view', 'id' => $post->id, '#' => 'comments']) ?>"><i class="fa fa-comments fa-2x" aria-hidden="true"></i></a></li>
        </ul>
    </div>
</article>
