<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

$this->registerCssFile('@web/lib/lightbox/css/lightbox.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/lib/lightbox/js/lightbox-2.6.min.js', ['position' => \yii\web\View::POS_HEAD]);

?>

<div class="pull-right" style="margin-left: 20px;">
    <?=\frontend\widgets\filter\Year::widget(array('checked' => $year))?>
</div>
<div class="pull-right">
    <?=\frontend\widgets\filter\Geo::widget(array('checked' => $geo))?>
</div>

<?php if (\yii::$app->user->can(\common\components\Rbac::OP_NEWS_CREATE)): ?>
    <a href="<?=Url::toRoute(['/staff/news/edit'])?>" class="btn btn-success btn-lg">
        <?=\yii::t('app', 'Add News')?>
    </a>
    <hr />
<?php endif; ?>

<?php foreach ($newsList as $news): ?>
    <div class="news">
        <h2 class="news-title">
            <a href="<?=Url::toRoute(['/news/view', 'id' => $news->commonId])?>"><?=Html::encode($news->title)?></a>
            <?php if (\yii::$app->user->can(\common\components\Rbac::OP_NEWS_UPDATE, array('news' => $news))): ?>
                <?=\frontend\widgets\news\StatusSwitcher::widget(array('news' => $news))?>
                <a href="<?=Url::toRoute([
                    '/staff/news/edit',
                    'id'    => $news->commonId,
                    'lang'  => $news->lang,
                ])?>" class="btn btn-link">
                    <?=\yii::t('app', 'Edit')?>
                </a>
            <?php endif; ?>
        </h2>
        <p class="news-date"><?=\frontend\widgets\news\Date::widget(array('news' => $news))?></p>

        <?php if (count($news->imagesIds) > 0): ?>
            <div class="row">
                <div class="col-lg-12">
                    <?php foreach ($news->imagesIds as $imageId): ?>
                        <a href="<?=Url::toRoute(['/news/image', 'id' => $imageId])?>" data-lightbox="img-<?=$news->id?>">
                            <img src="<?=Url::toRoute(['/news/image', 'id' => $imageId])?>" alt="" class="news-view__image-thumb" />
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
            <a href="<?=Url::toRoute(['latest', 'page' => $page - 1])?>">&larr; <?=\yii::t('app', 'Older')?></a>
        </li>
        <li class="next <?=($page >= $pageCount) ? 'disabled' : ''?>">
            <a href="<?=Url::toRoute(['latest', 'page' => $page + 1])?>"><?=\yii::t('app', 'Newer')?> &rarr;</a>
        </li>
    </ul>
<?php endif; ?>

<?php if (count($newsList) === 0): ?>
    <div class="alert alert-info">
        <?=\yii::t('app', 'No news yet.')?>
    </div>
<?php endif; ?>

<?php if (($page >= $pageCount) && ($year > \yii::$app->params['yearFirst'])): ?>
    <div style="text-align: center;">
        <a class="btn btn-default" href="<?=Url::toRoute(['', 'year' => $year - 1])?>">
            <?=\yii::t('app', 'News for the previous year: {year}', array(
                'year' => $year - 1,
            ))?>
        </a>
    </div>
<?php endif; ?>