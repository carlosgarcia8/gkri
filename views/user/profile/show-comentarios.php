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
$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <?php if ($suPerfil) : ?>
        <div class="hovereffect">
            <?= Html::img($profile->avatar, [
                'class' => 'img-thumbnail img-responsive',
                'alt' => $profile->user->username,
            ]) ?>
            <div class="overlay">
                <a class="upload info" href="#">Cambiar avatar</a>
                <?php $form = ActiveForm::begin() ?>
                    <?= $form->field($model, 'imageFile')->fileInput(['style' => 'visibility: hidden', 'label' => 'none', 'class' => 'uploadAvatar'])->label(false) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
        <?php else : ?>
        <div class="nohovereffect">
            <?= Html::img($profile->avatar, [
                'class' => 'img-thumbnail',
                'alt' => $profile->user->username,
            ]) ?>
        </div>
        <?php endif; ?>
        <div class="menu-profile-info">
            <h4><?= $this->title ?>
            <?php if (!empty($profile->gender)) : ?>
                <?php if ($profile->gender == 'M') : ?>
                    <i class="fa fa-mars" aria-hidden="true"></i>
                <?php else : ?>
                    <i class="fa fa-venus" aria-hidden="true"></i>
                <?php endif; ?>
            <?php endif; ?>
            </h4>
            <ul style="padding: 0; list-style: none outside none;">
                <?php if (!empty($profile->location)) : ?>
                    <li>
                        <i class="glyphicon glyphicon-map-marker text-muted"></i> <?= Html::encode($profile->location) ?>
                    </li>
                <?php endif; ?>
            </ul>
            <?php if (!empty($profile->bio)) : ?>
                <p><?= Html::encode($profile->bio) ?></p>
            <?php endif; ?>
            <div class="menu-follows">
            <?php if (!$suPerfil) : ?>
                <?php if ($esSeguidor) : ?>
                    <a href="javascript:void(0);" class="btn btn-info btn-siguiendo" data-follow-id="<?= $profile->user->id ?>">Siguiendo</a>
                    <a href="javascript:void(0);" class="btn btn-success btn-seguir btn-hide" data-follow-id="<?= $profile->user->id ?>">Seguir</a>
                    <a href="" class="btn btn-primary"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                <?php else : ?>
                    <a href="javascript:void(0);" class="btn btn-info btn-siguiendo btn-hide" data-follow-id="<?= $profile->user->id ?>">Siguiendo</a>
                    <a href="javascript:void(0);" class="btn btn-success btn-seguir" data-follow-id="<?= $profile->user->id ?>">Seguir</a>
                    <a href="" class="btn btn-primary"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                <?php endif; ?>
            <?php endif; ?>
                <div class="row">
                    <div class="col-sm-offset-2 col-sm-4">
                        <h6>Siguiendo: <span class="following-total"><?= $numeroSiguiendo ?></span></h6>
                    </div>
                    <div class="col-sm-4">
                        <h6>Seguidores: <span class="followers-total"><?= $numeroSeguidores ?></span></h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-profile-options">
            <ul>
                <li><?= Html::a('POSTS', ['/u/' . $profile->user->username . '/posts']) ?></li>
                <li><?= Html::a('VOTADOS', ['/u/' . $profile->user->username . '/votados']) ?></li>
                <li><?= Html::a('COMENTARIOS', ['/u/' . $profile->user->username . '/comentarios']) ?></li>
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
