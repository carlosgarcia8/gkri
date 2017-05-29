<?php
use yii\helpers\Html;

foreach ($diezMejores as $index => $post) :
if ($post->getRuta() !== false) :
?>
<article class="item-top item-top-post-<?= $post->id ?>" <?php if ($index === 0) : ?>
    data-step="4" data-position="left" data-intro="Aquí veremos una lista con los mejores posts de siempre." <?php endif; ?>>
    <header><h3><?= Html::a($post->titulo, ['/posts/view', 'id' => $post->id]) ?></h3></header>
    <div class="image-top-container">
        <?= Html::a(Html::img($post->ruta . '?t=' . date('d-m-Y-H:i:s'), ['class' => 'image-top', 'alt'=> $post->ruta]), ['/posts/view', 'id' => $post->id]) ?>
    </div>
</article>
<?php endif; ?>
<?php endforeach; ?>
