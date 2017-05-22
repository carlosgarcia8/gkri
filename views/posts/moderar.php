<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="container list-view">
    <article class="item">
        <?php if ($post) : ?>
        <header><h2><?= Html::a($post->titulo, ['/posts/view', 'id' => $post->id]) ?></h2></header>
        <div class="panel panel-default">
            <?php if ($post->extension == 'gif') : ?>
                <video width="455" loop="loop" autoplay="autoplay">
                    <source src="<?= $post->ruta . '?t=' . date('d-m-Y-H:i:s') ?>" type="video/mp4">
                </video>
            <?php else : ?>
                <?= Html::a(Html::img($post->ruta . '?t=' . date('d-m-Y-H:i:s'), ['class' => 'responsive-image', 'alt'=> $post->ruta]), ['/posts/view', 'id' => $post->id]) ?>
            <?php endif; ?>
            <div class="panel-body">
                <?= Html::a('Aceptar', ['/posts/aceptar', 'id' => $post->id], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Rechazar', ['/posts/rechazar', 'id' => $post->id], ['class' => 'btn btn-danger']) ?>
                <strong class="pull-right label label-default categoria-moderar">Categoría: <?= $post->categoria->nombre ?></strong>
        </div>
        <?php else : ?>
        <header><h4>No hay posts que moderar. Vuelva mas tarde.</h4></header>
        <?php endif; ?>
    </article>
</div>
