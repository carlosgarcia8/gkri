<?php
use app\models\MessageForm;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\Html;

// TODO intentar traer los mensajes cuando haya nuevo
// TODO las fechas en heroku postgresql se muestran -2 horas
$model = new MessageForm;
?>
<!-- Modal -->
<div class="modal fade" id="messages" tabindex="-1" role="dialog"
     aria-labelledby="messages" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title text-center">
                    Mensajes Privados
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-2 panel-wrap">
                    <?php Pjax::begin(); ?>
                    <?= Html::a('', '', ['id' => 'trigger-messages-pjax']) ?>
                    <div class="row content-wrap conversaciones">
                    <!-- Distintas conversaciones -->
                    <?php foreach ($conversaciones as $conversacion) :

                        $userConversacion = User::findOne(['id' => $conversacion['user_id']]);
                        ?>
                        <div class="conversation btn" data-id="<?= $conversacion['user_id'] ?>" itemscope itemtype="http://schema.org/Conversation">
                            <div class="media-body" itemprop="character" itemscope itemtype="http://schema.org/Person">
                                <span class="chat-img pull-left" itemprop="address">
                                    <img src="<?= $userConversacion->getAvatar() ?>" alt="User Avatar" class="little-message img-circle" />
                                </span>
                                <h5 class="media-heading" itemprop="additionalName"><?= $conversacion['username'] ?></h5>
                                <small class="pull-right time"><?= date_format(new DateTime($conversacion['last_message']), 'd/m/Y H:i:s') ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <?php Pjax::end(); ?>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-10 panel-wrap">

                    <div class="row content-wrap messages">

                    </div>
                    <!--Message box & Send Button-->
                    <div class="row send-wrap">
                        <div class="send-message">
                            <?php $form = ActiveForm::begin([
                                'enableClientValidation' => true,
                                'id' => 'mensajes-form',
                                'fieldConfig' => [
                                    'options' => [
                                        'tag' => false,
                                    ],
                                ],
                            ]); ?>
                            <div class="message-text">
                                <?= $form->field($model, 'texto')->textarea([
                                    'class' => 'no-resize-bar form-control',
                                    'rows' => 2,
                                    'data-username' => $user->username,
                                    'id' => 'textarea-message',
                                    'placeholder' => 'Escriba un mensaje...(Como máximo 255 carácteres)',
                                    ])->label(false) ?>
                            </div>

                            <div class="send-button">
                                <a class="btn btn-disabled btn-block btn-enviar-mensaje">Enviar <span class="fa fa-send"></span></a>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
