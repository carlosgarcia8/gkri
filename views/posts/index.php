<?php

use yii\bootstrap\Alert;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="container list-view">
    <?php
    if (Yii::$app->session->getFlash('upload')) {
        echo Alert::widget([
            'options' => ['class' => 'alert-info'],
            'body' => Yii::$app->session->getFlash('upload'),
        ]);
    } ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_view.php',
        'layout' => "{items}\n{pager}",
    ]) ?>
</div>
