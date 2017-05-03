<?php

use yii\bootstrap\Alert;
use yii\web\View;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';

$this->registerJs("
    $('.viewport:not(:in-viewport(0))').each(function(index) {
        $(this).next().find('video').addClass('video-paused').get(0).pause();
        $(this).next().find('ins').show();
    });

    if ($( '.viewport' ).isInViewport({ tolerance: 0 }).length != 0) {
        $('.viewport').isInViewport({ tolerance: 0 }).each(function() {
            $( this ).next().find('video').removeClass('video-paused').get(0).play();
            $(this).next().find('ins').hide();
        });
    }

    $('video').on('click', function() {
        if ($(this).get(0).paused) {
            $(this).get(0).play();
            $(this).next().hide();
        } else {
            $(this).addClass('video-paused').get(0).pause();
            $(this).next().show();
        }
    });

    $(window).scroll(function() {
        $('.viewport:not(:in-viewport(0))').each(function(index) {
            $(this).next().find('video').addClass('video-paused').get(0).pause();
            $(this).next().find('ins').show();
        });

        if ($( '.viewport' ).isInViewport({ tolerance: 0 }).length != 0) {
            $('.viewport').isInViewport({ tolerance: 0 }).each(function() {
                $( this ).next().find('video').removeClass('video-paused').get(0).play();
                $(this).next().find('ins').hide();
            });
        }
    });
",
\yii\web\View::POS_READY,
'isinviewport-js');
$this->registerJsFile('@web/js/votar.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
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
