<?php \yii::app()->clientScript->registerCoreScript('lightbox'); ?>

<div class="pull-right" style="margin-left: 20px;">
    <?php \web\widgets\filter\Year::create(array('checked' => $year)); ?>
</div>
<div class="pull-right">
    <?php \web\widgets\filter\Geo::create(array('checked' => $geo)); ?>
</div>

<?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_NEWS_CREATE)): ?>
    <a href="<?=$this->createUrl('/staff/news/edit')?>" class="btn btn-success btn-lg">
        <?=\yii::t('app', 'Add News')?>
    </a>
    <hr />
<?php endif; ?>

<?php foreach ($newsList as $news): ?>
    <div class="news">
        <h2 class="news-title">
            <a href="<?=$this->createUrl('/news/view', array('id' => $news->commonId))?>"><?=\CHtml::encode($news->title)?></a>
            <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_NEWS_UPDATE, array('news' => $news))): ?>
                <?php \web\widgets\news\StatusSwitcher::create(array('news' => $news)); ?>
                <a href="<?=$this->createUrl('/staff/news/edit', array(
                    'id'    => $news->commonId,
                    'lang'  => $news->lang,
                ))?>" class="btn btn-link">
                    <?=\yii::t('app', 'Edit')?>
                </a>
            <?php endif; ?>
        </h2>
        <p class="news-date"><?php \web\widgets\news\Date::create(array('news' => $news)); ?></p>

        <?php if (count($news->imagesIds) > 0): ?>
            <div class="row">
                <div class="col-lg-12">
                    <?php foreach ($news->imagesIds as $imageId): ?>
                        <a href="<?=$this->createUrl('/news/image', array('id' => $imageId))?>" data-lightbox="img-<?=(string)$news->_id?>">
                            <img src="<?=$this->createUrl('/news/image', array('id' => $imageId))?>.jpg" alt="" class="news-view__image-thumb" />
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <p class="news-content"><?=$news->content?></p>
        <hr />
    </div>
<?php endforeach; ?>

<?php if ($newsCount < $totalCount): ?>
    <ul class="pager">
        <li class="previous <?=($page <= 1) ? 'disabled' : ''?>">
            <a href="<?=$this->createUrl('latest', array('page' => $page - 1))?>">&larr; <?=\yii::t('app', 'Older')?></a>
        </li>
        <li class="next <?=($page >= $pageCount) ? 'disabled' : ''?>">
            <a href="<?=$this->createUrl('latest', array('page' => $page + 1))?>"><?=\yii::t('app', 'Newer')?> &rarr;</a>
        </li>
    </ul>
<?php endif; ?>

<?php if (count($newsList) === 0): ?>
    <div class="alert alert-info">
        <?=\yii::t('app', 'No news yet.')?>
    </div>
<?php endif; ?>

<?php if (($page >= $pageCount) && ($year > \yii::app()->params['yearFirst'])): ?>
    <div style="text-align: center;">
        <a class="btn btn-default" href="<?=$this->createUrl('', array('year' => $year - 1))?>">
            <?=\yii::t('app', 'News for the previous year: {year}', array(
                '{year}' => $year - 1,
            ))?>
        </a>
    </div>
<?php endif; ?>