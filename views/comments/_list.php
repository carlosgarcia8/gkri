<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii2mod\editable\Editable;

/* @var $this \yii\web\View */
/* @var $model \yii2mod\comments\models\CommentModel */
/* @var $maxLevel null|integer comments max level */

// TODO arreglar los javascript:void(0)
?>
<li class="comment">
    <div class="comment-content" id="comment-list-<?= $model->id ?>" data-comment-content-id="<?php echo $model->id ?>">
        <div class="comment-author-avatar">
            <?php echo Html::img($model->getAvatar(), ['alt' => $model->getAuthorName(), 'width' => '50', 'height' => '50']); ?>
        </div>
        <div class="comment-details">
            <div class="comment-action-buttons">
                <?php if (Yii::$app->user->isGuest) :?>
                <?php elseif (Yii::$app->user->identity->isAdmin) :?>
                    <?php echo Html::a('<span class="glyphicon glyphicon-trash"></span> <span class="texto-button">' . Yii::t('yii2mod.comments', 'Delete') . '</span>', '#', ['data' => ['action' => 'delete', 'url' => Url::to(['/comment/default/delete', 'id' => $model->id]), 'comment-id' => $model->id]]); ?>
                <?php elseif (!$model->isChild() && !$model->tieneHijos() && ($model->createdBy == Yii::$app->user->identity->id)) :?>
                    <?php echo Html::a('<span class="glyphicon glyphicon-trash"></span> <span class="texto-button">' . Yii::t('yii2mod.comments', 'Delete') . '</span>', '#', ['data' => ['action' => 'delete', 'url' => Url::to(['/comment/default/delete', 'id' => $model->id]), 'comment-id' => $model->id]]); ?>
                <?php elseif ($model->isChild() && ($model->createdBy == Yii::$app->user->identity->id)) :?>
                    <?php echo Html::a('<span class="glyphicon glyphicon-trash"></span> <span class="texto-button">' . Yii::t('yii2mod.comments', 'Delete') . '</span>', '#', ['data' => ['action' => 'delete', 'url' => Url::to(['/comment/default/delete', 'id' => $model->id]), 'comment-id' => $model->id]]); ?>
                <?php endif; ?>

                <?php if (!Yii::$app->user->isGuest && ($model->level < $maxLevel || is_null($maxLevel))) : ?>
                    <?php echo Html::a('<span class="glyphicon glyphicon-share-alt"></span> <span class="texto-button">' . Yii::t('yii2mod.comments', 'Reply') . '</span>', '#', ['class' => 'comment-reply', 'data' => ['action' => 'reply', 'comment-id' => $model->id]]); ?>
                <?php endif; ?>
            </div>
            <div class="comment-author-name">
                <ul class="btn-vote-comment left">
                    <?php if ($model->esAutor()) : ?>
                    <span class="fa fa-user-circle-o post-author" aria-hidden="true" title="Autor"></span>
                    <a href="/u/<?= $model->getAuthorName() ?> " class="author-comment"><span><?php echo $model->getAuthorName(); ?> </span></a>
                    <?php else: ?>
                    <a href="/u/<?= $model->getAuthorName() ?> " class="author-comment"><span><?php echo $model->getAuthorName(); ?></span></a>
                    <?php endif; ?>
                    <?php if ($model->estaUpvoteado()) : ?>
                        <li><a href="javascript:void(0);" class="comment-vote-up voted-up" data-comment-id="<?= $model->id ?>"><span class="fa fa-thumbs-up" aria-hidden="true"></span></a></li>
                    <?php else: ?>
                        <li><a href="javascript:void(0);" class="comment-vote-up" data-comment-id="<?= $model->id ?>"><span class="fa fa-thumbs-up" aria-hidden="true"></span></a></li>
                    <?php endif; ?>

                    <?php if ($model->estaDownvoteado()) : ?>
                        <li><a href="javascript:void(0);" class="comment-vote-down voted-down" data-comment-id="<?= $model->id ?>"><span class="fa fa-thumbs-down" aria-hidden="true"></span></a></li>
                    <?php else: ?>
                        <li><a href="javascript:void(0);" class="comment-vote-down" data-comment-id="<?= $model->id ?>"><span class="fa fa-thumbs-down" aria-hidden="true"></span></a></li>
                    <?php endif; ?>
                    <span class="comment-votos-total comment-votos-total-<?= $model->id ?>"><?= $model->getVotosTotal(); ?> votos  |  </span>
                    <span class="comment-date"><?= $model->getPostedDate(); ?></span>
                </ul>
            </div>
            <div class="comment-body">
                <?php if (Yii::$app->getModule('comment')->enableInlineEdit): ?>
                    <?php echo Editable::widget([
                        'model' => $model,
                        'attribute' => 'content',
                        'url' => '/comment/default/quick-edit',
                        'options' => [
                            'id' => 'editable-comment-' . $model->id,
                        ],
                    ]); ?>
                <?php else: ?>
                    <?php echo $model->getContent(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</li>
<?php if ($model->hasChildren()) : ?>
    <ul class="children">
        <?php foreach ($model->getChildren() as $children) : ?>
            <li class="comment" id="comment-<?php echo $children->id; ?>">
                <?php echo $this->render('_list', ['model' => $children, 'maxLevel' => $maxLevel]) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
