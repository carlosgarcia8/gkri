<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form col-lg-offset-1 col-lg-10 col-xs-12 col-sm-12 col-sm-offset-0 col-md-offset-1 col-md-10">

    <div class="post-form-spinner">

    </div>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
        'id' => 'upload-post-form',
        'action' => '/upload'
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
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group col-lg-6 col-xs-12 col-sm-6">
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
        <div class="col-lg-6 col-xs-12 col-sm-6">
            <?= Html::submitButton('<span class="fa fa-upload" aria-hidden="true" title="Upload"></span> Enviar', ['class' => 'btn btn-success btn-upload-post']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
