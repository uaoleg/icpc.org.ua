<?php if (\yii::app()->user->checkAccess('newsCreate')): ?>
    <a href="<?=$this->createUrl('/staff/news/create')?>" class="btn btn-success btn-lg"><?=\yii::t('app', 'Add News')?></a>
    <hr />
<?php endif; ?>

<?php foreach ($newsList as $news): ?>
    <div class="news">
        <h2 class="news-title">
            <a href="<?=$this->createUrl('/news/view', array('id' => $news->_id))?>"><?=CHtml::encode($news->title)?></a>
            <?php if (\yii::app()->user->checkAccess('newsUpdate', array('news' => $news))): ?>
                <?php $this->widget('\web\widgets\news\StatusSwitcher', array('news' => $news)); ?>
                <a href="<?=$this->createUrl('/staff/news/edit', array('id' => $news->_id))?>" class="btn btn-link">
                    <?=\yii::t('app', 'Edit')?>
                </a>
            <?php endif; ?>
        </h2>
        <p class="news-date"><?php $this->widget('\web\widgets\news\Date', array('news' => $news)); ?></p>
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


