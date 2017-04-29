<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii2mod\editable\Editable;
use yii\web\View;

/* @var $this \yii\web\View */
/* @var $model \yii2mod\comments\models\CommentModel */
/* @var $maxLevel null|integer comments max level */

$this->registerJsFile('@web/js/votar-comentarios.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);

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
                    <?php echo Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('yii2mod.comments', 'Delete'), '#', ['data' => ['action' => 'delete', 'url' => Url::to(['/comment/default/delete', 'id' => $model->id]), 'comment-id' => $model->id]]); ?>
                <?php elseif (!$model->isChild() && !$model->tieneHijos() && ($model->createdBy == Yii::$app->user->identity->id)) :?>
                    <?php echo Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('yii2mod.comments', 'Delete'), '#', ['data' => ['action' => 'delete', 'url' => Url::to(['/comment/default/delete', 'id' => $model->id]), 'comment-id' => $model->id]]); ?>
                <?php elseif ($model->isChild() && ($model->createdBy == Yii::$app->user->identity->id)) :?>
                    <?php echo Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('yii2mod.comments', 'Delete'), '#', ['data' => ['action' => 'delete', 'url' => Url::to(['/comment/default/delete', 'id' => $model->id]), 'comment-id' => $model->id]]); ?>
                <?php endif; ?>

                <?php if (!Yii::$app->user->isGuest && ($model->level < $maxLevel || is_null($maxLevel))) : ?>
                    <?php echo Html::a("<span class='glyphicon glyphicon-share-alt'></span> " . Yii::t('yii2mod.comments', 'Reply'), '#', ['class' => 'comment-reply', 'data' => ['action' => 'reply', 'comment-id' => $model->id]]); ?>
                <?php endif; ?>
            </div>
            <div class="comment-author-name">
                <ul class="btn-vote-comment left">
                    <a href="/u/<?= $model->getAuthorName() ?> " class="author-comment"><span><?php echo $model->getAuthorName(); ?></span></a>
                    <?php if ($model->estaUpvoteado()) : ?>
                        <li><a href="javascript:void(0);" class="comment-vote-up voted-up" data-comment-id="<?= $model->id ?>"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></li>
                    <?php else: ?>
                        <li><a href="javascript:void(0);" class="comment-vote-up" data-comment-id="<?= $model->id ?>"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></li>
                    <?php endif; ?>

                    <?php if ($model->estaDownvoteado()) : ?>
                        <li><a href="javascript:void(0);" class="comment-vote-down voted-down" data-comment-id="<?= $model->id ?>"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a></li>
                    <?php else: ?>
                        <li><a href="javascript:void(0);" class="comment-vote-down" data-comment-id="<?= $model->id ?>"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a></li>
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
