<?php
use yii\helpers\Html;
use yii\web\View;


$js = <<<EOT
    $("#meme").memeGenerator({
		useBootstrap: true,
		layout: "horizontal",
        showAdvancedSettings: false,
        dragResizeEnabled: false,
        outputFormat: 'image/jpeg',
		captions: [
			"TOP TEXT",
            'BOTTOM TEXT'
		],
        onInit: function(){
    	    $('.mg-controls').children('.container-fluid').append('<button class="btn btn-success btn-block" id="download">Generar</button>');
            $("#download").click(function(e){
        		e.preventDefault();

        		$("#meme").memeGenerator("download", "meme.jpg");
        	});
        }
	});


EOT;
$this->registerCssFile('@web/css/jquery.memegenerator.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@web/js/jquery.memegenerator.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->registerJs($js);
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 meme-container">
    <?= Html::img("/$fichero", ['class' => 'meme-gen-create', 'alt' => $fichero, 'id' => 'meme']) ?>
</div>
