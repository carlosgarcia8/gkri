<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="container list-view">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_viewm.php',
        'layout' => "{items}\n{pager}",
    ]) ?>
</div>
