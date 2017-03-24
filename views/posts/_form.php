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

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]); ?>
    <div class="form-group col-lg-12">
        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="form-group col-lg-8">
        <?= $form->field($model, 'imageFile')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'image/*',
            ],
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
            'data' => $categorias,
            'options' => ['placeholder' => 'Selecciona una categoría'],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
                'maximumInputLength' => 10
            ],
        ]); ?>
    </div>

    <div class="form-group col-lg-12">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
