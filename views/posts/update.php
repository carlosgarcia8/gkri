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

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group col-lg-12">
        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="form-group col-lg-8">
        <label class="control-label">Categoría</label>
        <?= Select2::widget([
            'name' => 'Post[categoria_id]',
            'value' => $model->categoria_id,
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
        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
