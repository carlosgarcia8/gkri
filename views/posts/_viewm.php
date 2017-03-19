<?php
use yii\helpers\Html;

?>
<article class="item">
    <header><h2><?= Html::a($model->titulo, ['posts/view', 'id' => $model->id]) ?></h2></header>
    <div class="">
        <?= Html::a(Html::img($model->ruta), ['posts/view', 'id' => $model->id]) ?>
        Pendiente de moderación
    </div>
</article>
