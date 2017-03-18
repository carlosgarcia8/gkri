<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */

$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <?php if ($suPerfil) : ?>
                <div class="hovereffect">
                    <?= Html::img($profile->avatar, [
                        'class' => 'img-thumbnail',
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
                <div class="">
                    <?= Html::img($profile->avatar, [
                        'class' => 'img-thumbnail',
                        'alt' => $profile->user->username,
                    ]) ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-sm-6 col-md-8">
                <h4><?= $this->title ?></h4>
                <ul style="padding: 0; list-style: none outside none;">
                    <?php if (!empty($profile->location)) : ?>
                        <li>
                            <i class="glyphicon glyphicon-map-marker text-muted"></i> <?= Html::encode($profile->location) ?>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($profile->website)) : ?>
                        <li>
                            <i class="glyphicon glyphicon-globe text-muted"></i> <?= Html::a(Html::encode($profile->website), Html::encode($profile->website)) ?>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($profile->public_email)) : ?>
                        <li>
                            <i class="glyphicon glyphicon-envelope text-muted"></i> <?= Html::a(Html::encode($profile->public_email), 'mailto:' . Html::encode($profile->public_email)) ?>
                        </li>
                    <?php endif; ?>
                    <li>
                        <i class="glyphicon glyphicon-time text-muted"></i> <?= Yii::t('user', 'Joined on {0, date}', $profile->user->created_at) ?>
                    </li>
                </ul>
                <?php if (!empty($profile->bio)) : ?>
                    <p><?= Html::encode($profile->bio) ?></p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
