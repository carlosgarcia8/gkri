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
                $('.alert-success')
                    .removeClass('template-oculto')
                    .fadeIn('slow')
                    .text('Gracias por usar el Generador de Memes. Esta ventana se cerrara en 8 segundos, ahora vuelva a la sección de Upload y elija la opción Subir un archivo del ordenador.');
        		$("#meme").memeGenerator("download", "meme.jpg");
                setTimeout(function () { close();}, 8000);
        	});
        }
	});


EOT;
$this->registerCssFile('@web/css/jquery.memegenerator.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@web/js/jquery.memegenerator.min.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->registerJs($js);
?>

<div class="alert alert-success template-oculto" role="alert"></div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 meme-container">
    <?= Html::img("/$fichero", ['class' => 'meme-gen-create', 'alt' => $fichero, 'id' => 'meme']) ?>
</div>
