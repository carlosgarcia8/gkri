<?php

use yii\bootstrap\Alert;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->registerJsFile('@web/js/gifs.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->registerJsFile('@web/js/votar.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
$this->registerJsFile('@web/js/back-to-top.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_END]);
?>
<a href="#" id="btn-arriba"><span class="fa fa-arrow-up fa-lg" aria-hidden="true"></span></a>
<div class="container">
    <div class="main-list">
        <?php
        if (Yii::$app->session->getFlash('upload')) {
            echo Alert::widget([
                'options' => ['class' => 'alert-info'],
                'body' => Yii::$app->session->getFlash('upload'),
            ]);
        } ?>
        <?php
        if (Yii::$app->session->getFlash('error')) {
            echo Alert::widget([
                'options' => ['class' => 'alert-danger'],
                'body' => Yii::$app->session->getFlash('error'),
            ]);
        } ?>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) : ?>
        <div class="busqueda">
            <a href="<?= Url::to('/moderar') ?>" class="moderar-btn btn btn-warning">
                Moderar (<?= $enModeracion ?>)
            </a>
            <a href="<?= Url::to('/user/admin') ?>" class="moderar-btn btn btn-danger">
                Administrar
            </a>
        </div>
        <?php endif; ?>
        <?php if(isset($categoria)) : ?>
            <?php if ($categoria === null) : ?>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_view.php',
                'showOnEmpty' => true,
                'layout' => "{items}\n{pager}",
            ]) ?>
            <?php else : ?>
                <?php if($existeCategoria) : ?>
                <div class="busqueda">
                    <h4>Búsqueda</h4>
                    <h5>Hay <?= $dataProvider->getCount() ?> resultados con categoría: <?= $categoria ?></h5>
                </div>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => '_view.php',
                    'showOnEmpty' => true,
                    'layout' => "{items}\n{pager}",
                ]) ?>
                <?php else : ?>
                <h5>No existe la categoria que ha especificado: <?= $categoria ?></h5>
                <?php endif; ?>
            <?php endif; ?>
        <?php else : ?>
            <?php if(isset($titulo)) : ?>
                <?php if ($titulo === null) : ?>
                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => '_view.php',
                        'showOnEmpty' => true,
                        'layout' => "{items}\n{pager}",
                    ]) ?>
                <?php else : ?>
                <div class="busqueda">
                    <h4>Búsqueda</h4>
                    <h5>Hay <?= $dataProvider->getCount() ?> resultados cuyo título empiezan por: "<?= $titulo ?>"</h5>
                </div>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => '_view.php',
                    'showOnEmpty' => true,
                    'layout' => "{items}\n{pager}",
                ]) ?>
                <?php endif; ?>
            <?php else : ?>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => '_view.php',
                    'showOnEmpty' => true,
                    'layout' => "{items}\n{pager}",
                ]) ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="top-ten-list">
        <?= $this->render('_view-top', ['diezMejores' => $diezMejores]) ?>
    </div>
</div>
