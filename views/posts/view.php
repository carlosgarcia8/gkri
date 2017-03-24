<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($esAdmin) : ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p><?php endif; ?>

    <article class="item">
        <header><h2><?= Html::a($model->titulo, ['posts/view', 'id' => $model->id]) ?></h2></header>
        <div class="">
            <?= Html::a(Html::img($model->ruta), ['posts/view', 'id' => $model->id]) ?>
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
    </article>

</div>
