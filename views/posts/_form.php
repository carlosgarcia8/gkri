<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form col-lg-offset-3 col-lg-6 col-sm-offset-1 col-xs-offset-0 col-xs-12 col-sm-10 col-md-6 col-md-offset-3 template-oculto">
    <div class="post-form-spinner">

    </div>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
        'id' => 'upload-post-form'
    ]); ?>
    <div class="form-group col-lg-12">
        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="form-group col-lg-12">
        <?= $form->field($model, 'imageFile')->label('Imagen')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'image/*',
            ],
            'language' => 'es',
            'pluginOptions' => [
                'showUpload' => false,
            ]
        ]); ?>
    </div>
    <div class="form-group col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 col-xs-12">
        <label class="control-label">Categoría</label>
        <?= Select2::widget([
            'name' => 'Post[categoria_id]',
            'value' => 1,
            'language' => 'es',
            'data' => $categorias,
            // 'hideSearch' => true,
            'options' => ['placeholder' => 'Selecciona una categoría'],
            'pluginOptions' => [
            ],
        ]); ?>
    </div>

    <div class="form-group col-lg-12 col-xs-12">
        <a href="#" class="button-volver btn btn-info">Volver</a>
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success btn-upload-post']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
