<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = 'Enviar un Post';
// $this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/upload-post.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
?>
<div class="post-create">
    <?php
    if (Yii::$app->session->getFlash('error')) {
        echo Alert::widget([
            'options' => ['class' => 'alert-danger'],
            'body' => Yii::$app->session->getFlash('error'),
        ]);
    } ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categorias' => $categorias,
    ]) ?>

</div>
