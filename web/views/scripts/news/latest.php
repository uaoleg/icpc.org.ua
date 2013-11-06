<div class="btn-group pull-right">
    <?php if (\yii::app()->params['yearFirst'] < date('Y')): ?>
        <button class="btn btn-default active dropdown-toggle" data-toggle="dropdown">
            <?=\yii::t('app', '{year} year', array(
                '{year}' => $year,
            ))?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <?php foreach (range(date('Y'), \yii::app()->params['yearFirst']) as $_year): ?>
                <?php if ($year === $_year) continue; ?>
                <li><a href="<?=$this->createUrl('', array('year' => $_year))?>"><?=\yii::t('app', '{year} year', array(
                    '{year}' => $_year,
                ))?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <button class="btn btn-default active" data-toggle="dropdown">
            <?=\yii::t('app', '{year} year', array(
                '{year}' => date('Y'),
            ))?>
        </button>
    <?php endif; ?>
</div>

<?php if (\yii::app()->user->checkAccess('newsCreate')): ?>
    <a href="<?=$this->createUrl('/staff/news/edit')?>" class="btn btn-success btn-lg">
        <?=\yii::t('app', 'Add News')?>
    </a>
    <hr />
<?php endif; ?>

<?php foreach ($newsList as $news): ?>
    <div class="news">
        <h2 class="news-title">
            <a href="<?=$this->createUrl('/news/view', array('id' => $news->commonId))?>"><?=CHtml::encode($news->title)?></a>
            <?php if (\yii::app()->user->checkAccess('newsUpdate', array('news' => $news))): ?>
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