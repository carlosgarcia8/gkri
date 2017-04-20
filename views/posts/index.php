<?php

use yii\bootstrap\Alert;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
// $this->params['breadcrumbs'][] = $this->title;
// TODO cuando no esta logeado y le da a votar, cambia el color antes de mandarnos
// al login
$js = <<<EOT

$('.vote-up').on('click', function() {
    votar($(this).attr('alt'), true);

    $(this).parent().next().find('a').removeClass('voted-down');

    if ($(this).hasClass('voted-up')) {
        $(this).removeClass('voted-up');
    } else {
        $(this).addClass('voted-up');
    }
});

$('.vote-down').on('click', function() {
    votar($(this).attr('alt'), false);

    $(this).parent().prev().find('a').removeClass('voted-up');

    if ($(this).hasClass('voted-down')) {
        $(this).removeClass('voted-down');
    } else {
        $(this).addClass('voted-down');
    }
});

function votar(id, positivo) {
    var parametros = {
        "id" : id,
        "positivo": positivo
    };
    $.ajax({
        data:  parametros,
        url:   '/posts/votar',
        type:  'get',
        success: function (data) {
            $('.votos-total-' + id).html(data + ' votos');
        }
    });
}
EOT;
$this->registerJs($js);
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
