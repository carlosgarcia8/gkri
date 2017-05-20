<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<!-- Button trigger modal -->
<button class="btn btn-primary" data-toggle="modal" data-target="#myModalNorm">
    <span class="fa fa-envelope" aria-hidden="true"></span>
</button>

<!-- Modal -->
<div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Enviar Mensaje a: <b><?= $username ?></b>
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'enableClientValidation' => true,
                    'id' => 'mensaje-form',
                ]); ?>
                <div class="form-group">
                    <?= $form->field($model, 'texto')->textarea([
                        'class' => 'form-control',
                        'style' => 'resize: none;',
                        'rows' => 5,
                        ])->label('') ?>
                </div>
                <?= $form->field($model, 'receptor_id')->hiddenInput(['value' => $receptor_id])->label('') ?>

                <?= Html::submitButton(Yii::t('user', 'Send'), ['class' => 'btn btn-primary btn-enviar-mensaje']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
