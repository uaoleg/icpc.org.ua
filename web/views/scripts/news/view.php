<div class="page-header">
    <h1><?=\CHtml::encode($news->title)?></h1>
</div>
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
                <img src="<?=$this->createUrl('/news/image', array('id' => $imageId))?>" alt="">
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
<p><?=$news->content?></p>