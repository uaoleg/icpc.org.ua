<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

$this->registerCssFile('@web/lib/lightbox/css/lightbox.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/lib/lightbox/js/lightbox-2.6.min.js', ['position' => \yii\web\View::POS_HEAD]);

?>

<div class="page-header">
    <h1><?=Html::encode($news->title)?></h1>
</div>

<?php if (count($imagesIds)): ?>
    <div class="row">
        <div class="col-lg-12">
            <?php foreach($imagesIds as $imageId): ?>
                <a href="<?=Url::toRoute(['/news/image', 'id' => $imageId])?>" data-lightbox="img-<?=$news->id?>">
                    <img src="<?=Url::toRoute(['/news/image', 'id' => $imageId])?>" alt="" class="news-view__image-thumb" />
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<p><?=$news->content?></p>