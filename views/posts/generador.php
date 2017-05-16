<?php
use yii\helpers\Html;



?>

<h3 class="text-center">Elige una imagen</h3>
<?php foreach ($ficheros as $fichero) : ?>
<div class="col-lg-3 col-md-4 col-sm-6 col-sm-offset-0 col-xs-offset-3 col-xs-6 meme-container">
    <?= Html::a(Html::img('/'.Yii::getAlias('@generador').'/'.$fichero, ['class' => 'meme-gen', 'alt' => $fichero]), ['/posts/generador-crear', 'fichero' => $fichero]) ?>
</div>
<?php endforeach; ?>
