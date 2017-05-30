<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\Alert;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */
if ($profile !== null) :
$this->registerJsFile('@web/js/gifs.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->registerJsFile('@web/js/votar.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->registerJsFile('@web/js/follow.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->registerJsFile('@web/js/back-to-top.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
?>
<a href="#" id="btn-arriba"><span class="fa fa-arrow-up fa-lg" aria-hidden="true"></span></a>
<div class="row">
    <div class="alert alert-success fade in" id="message-create" style="display:none;">
        <button type="button" class="close">×</button>
        Tu mensaje ha sido enviado correctamente.
    </div>
    <div class="alert alert-danger fade in" id="upload-client-error" style="display:none;">
        <button type="button" class="close">×</button>
        <span></span>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-3">
        <?php if ($suPerfil) : ?>
        <div class="hovereffect">
            <?= Html::img($profile->avatar . '?t=' . date('d-m-Y-H:i:s'), [
                'class' => 'img-thumbnail img-responsive',
                'alt' => $profile->user->username,
            ]) ?>
            <div class="overlay">
                <a class="upload info" href="#">Cambiar avatar</a>
                <?php $form = ActiveForm::begin([
                    'enableClientValidation' => false,
                    ]) ?>
                    <?= $form->field($model, 'imageFile')->fileInput(['style' => 'visibility: hidden', 'label' => 'none', 'class' => 'uploadAvatar'])->label(false) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
        <?php else : ?>
        <div class="nohovereffect">
            <?= Html::img($profile->avatar . '?t=' . date('d-m-Y-H:i:s'), [
                'class' => 'img-thumbnail',
                'alt' => $profile->user->username,
            ]) ?>
        </div>
        <?php endif; ?>
        <div class="menu-profile-info">
            <h4><?= $this->title ?>
            <?php if (!empty($profile->gender)) : ?>
                <?php if ($profile->gender == 'M') : ?>
                    <span class="fa fa-mars" aria-hidden="true"></span>
                <?php else : ?>
                    <span class="fa fa-venus" aria-hidden="true"></span>
                <?php endif; ?>
            <?php endif; ?>
            </h4>
            <ul style="padding: 0; list-style: none outside none;">
                <?php if (!empty($profile->location)) : ?>
                    <li>
                        <span class="glyphicon glyphicon-map-marker text-muted"></span> <?= Html::encode($profile->location) ?>
                    </li>
                <?php endif; ?>
            </ul>
            <?php if (!empty($profile->bio)) : ?>
                <p><?= Html::encode($profile->bio) ?></p>
            <?php endif; ?>
            <div class="menu-follows">
                <div class="row">
                    <div class="col-md-offset-2 col-md-4 col-sm-offset-4 col-sm-2 col-xs-offset-0 col-xs-6">
                        <h2><strong class="following-total"> <?= $numeroSiguiendo ?> </strong></h2>
                        <p><small>Siguiendo</small></p>
                    </div>
                    <div class="col-sm-2 col-xs-6 col-md-4">
                        <h2><strong class="followers-total"> <?= $numeroSeguidores ?> </strong></h2>
                        <p><small>Seguidores</small></p>
                    </div>
                </div>
                <?php if (!Yii::$app->user->isGuest && !$suPerfil) : ?>
                    <?php if ($esSeguidor) : ?>
                        <a href="" class="btn btn-info btn-siguiendo" data-follow-id="<?= $profile->user->id ?>">Siguiendo</a>
                        <a href="" class="btn btn-success btn-seguir btn-hide" data-follow-id="<?= $profile->user->id ?>">Seguir</a>
                        <?= $this->render('_message', ['model'=>$messageForm, 'username' => $this->title, 'receptor_id' => $profile->user->id]) ?>
                    <?php else : ?>
                        <a href="" class="btn btn-info btn-siguiendo btn-hide" data-follow-id="<?= $profile->user->id ?>">Siguiendo</a>
                        <a href="" class="btn btn-success btn-seguir" data-follow-id="<?= $profile->user->id ?>">Seguir</a>
                        <?= $this->render('_message', ['model'=>$messageForm, 'username' => $this->title, 'receptor_id' => $profile->user->id]) ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="menu-profile-options">
            <ul>
                <li><?= Html::a('PUBLICADOS', ['/u/' . $profile->user->username . '/posts']) ?></li>
                <li><?= Html::a('VOTADOS', ['/u/' . $profile->user->username . '/votados']) ?></li>
                <li><?= Html::a('COMENTADOS', ['/u/' . $profile->user->username . '/comentarios']) ?></li>
            </ul>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-8">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '../../posts/_view-comentarios.php',
            'layout' => "{items}\n{pager}",
            'viewParams' => [
                'profile' => $profile,
            ],
        ]) ?>
    </div>
</div>
<?php else : ?>
<div class="row">
    <?php
    if (Yii::$app->session->getFlash('nouser')) {
        $url = Url::to(['/'], true);

        echo Alert::widget([
            'options' => ['class' => 'alert-info'],
            'body' => Yii::$app->session->getFlash('nouser'),
        ]);

        \Yii::$app->view->registerMetaTag([
        'http-equiv' => 'refresh',
        'content' => "5;url={$url}"
    ]);
    } ?>
</div>
<?php endif; ?>
