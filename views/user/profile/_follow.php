<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Follow;

$siguiendo = Follow::findOne(['user_id' => Yii::$app->user->id, 'follow_id' => $model->id]) !== null;

?>

<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
    <div class="thumbnail">
        <a href="<?= Url::to('/u/' . $model->username) ?>">
            <div class="caption">
                <div class='col-lg-12'>
                    <?= Html::img($model->getAvatar(), ['class' => 'img-circle img-follow']) ?>
                </div>
                <div class='col-lg-12'>
                    <h4><?= $model->username ?></h4>
                </div>
            </div>
        </a>
    </div>
</div>
