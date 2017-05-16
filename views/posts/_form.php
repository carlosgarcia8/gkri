<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form col-lg-6">
    <div class="post-form-spinner">

    </div>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
        'id' => 'upload-post-form'
    ]); ?>
    <div class="form-group col-lg-12">
        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="form-group col-lg-8">
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
    <div class="form-group col-lg-8">
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

    <div class="form-group col-lg-12">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success btn-upload-post']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
