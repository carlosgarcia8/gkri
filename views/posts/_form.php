<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

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

    <div class="form-group col-lg-12">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
