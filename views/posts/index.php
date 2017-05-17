<?php

use yii\bootstrap\Alert;
use yii\web\View;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';

$js = <<<EOT
    if (document.documentElement.scrollTop < 1200) {
        $('#btn-arriba').hide();
    }
    $('#btn-arriba').click(function(e){
        e.preventDefault();

        $('html,body').animate({ scrollTop: 0 }, 'slow');
        return false;
    });
    $(window).scroll(function() {
        console.log(document.documentElement.scrollTop);
        if ($(document).height() - $(window).height() > document.documentElement.scrollTop) {
            $('#btn-arriba').css('bottom', '40px');
        } else {
            $('#btn-arriba').css('bottom', '80px');
        }
        if (document.documentElement.scrollTop > 1200) {
            $('#btn-arriba').show();
        } else {
            $('#btn-arriba').hide();
        }
    });
EOT;
$this->registerJs($js);
$this->registerJsFile('@web/js/gifs.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->registerJsFile('@web/js/votar.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
?>
<a href="#" id="btn-arriba"><i class="fa fa-arrow-up fa-lg" aria-hidden="true"></i></a>
<div class="container">
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
