<?php \yii::app()->getClientScript()->registerCoreScript('lightbox'); ?>

<div class="page-header">
    <h1><?=\CHtml::encode($news->title)?></h1>
</div>
<?php if(count($imagesIds)): ?>
    <div class="row">
        <div class="col-lg-12">
            <?php $i = 0; ?>
            <?php foreach($imagesIds as $imageId): ?>

                <a href="<?=$this->createUrl('/news/image', array('id' => $imageId))?>" data-lightbox="img">
                    <img src="<?=$this->createUrl('/news/image', array('id' => $imageId))?>.jpg" width="100" alt="" class="news-view__image_item">
                </a>

            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<p><?=$news->content?></p>