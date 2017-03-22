<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="container list-view">
    <article class="item">
        <?php if ($post) : ?>
        <header><h2><?= Html::a($post->titulo, ['posts/view', 'id' => $post->id]) ?></h2></header>
        <div class="panel panel-default">
            <?= Html::a(Html::img($post->ruta), ['posts/view', 'id' => $post->id]) ?>
            <div class="panel-body">
                <?= Html::a('Aceptar', ['posts/aceptar', 'id' => $post->id], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Rechazar', ['posts/rechazar', 'id' => $post->id], ['class' => 'btn btn-danger']) ?>
            </div>
        </div>
        <?php else : ?>
        <header><h4>No hay posts que moderar. Vuelva mas tarde.</h4></header>
        <?php endif; ?>
    </article>
</div>
