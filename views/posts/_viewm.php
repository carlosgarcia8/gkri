<?php
use yii\helpers\Html;

?>
<article class="item">
    <header><h2><?= Html::a($model->titulo, ['posts/view', 'id' => $model->id]) ?></h2></header>
    <div class="panel panel-default">
        <?= Html::a(Html::img($model->ruta), ['posts/view', 'id' => $model->id]) ?>
        <div class="panel-body">
            <?= Html::a('Aceptar', ['posts/aceptar', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Rechazar', ['posts/rechazar', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
        </div>
    </div>
</article>
