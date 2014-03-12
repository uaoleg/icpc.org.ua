<script>
    $(document).ready(function() {
        new appNewsView();
    });
</script>

<div class="page-header">
    <h1><?=\CHtml::encode($news->title)?></h1>
</div>
<?php if(count($imagesIds)): ?>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 text-center">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php $i = 0; ?>
                    <?php foreach($imagesIds as $imageId): ?>
                        <li data-target="#carousel-example-generic" data-slide-to="<?=$i?>" class="<?=($i++===0)?'active':''?>"></li>
                    <?php endforeach; ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <?php foreach($imagesIds as $imageId): ?>
                        <div class="item <?=($imageId === $imagesIds[0]) ? 'active' : ''?>">
                            <img src="<?=$this->createUrl('/news/image', array('id' => $imageId))?>.jpg" width="150" alt="" class="news-view__image_item">
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
<p><?=$news->content?></p>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-center">
            <img alt="">
        </div>
    </div>
</div>