<?php

use \yii\helpers\Html;
use \yii\helpers\Url;

$this->registerJsFile('@web/lib/ckeditor-4.2/ckeditor.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/lib/plupload-834/js/plupload.full.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/lib/plupload-834/js/jquery.plupload.queue/jquery.plupload.queue.min.js', ['position' => \yii\web\View::POS_HEAD]);

?>

<div class="page-header clearfix">
    <?php if (empty($news->commonId)): ?>
        <h1><?=\yii::t('app', 'Create News')?></h1>
    <?php else: ?>
        <h1><?=\yii::t('app', 'Edit News')?></h1>
        <small><b><?=\yii::t('app', 'Preview')?>:</b> <a href="<?=Url::toRoute([
            '/news/view',
            'id'    => $news->commonId,
            'lang'  => $news->lang,
        ])?>" target="_blank">
            <?=Url::toRoute(['/news/view', 'id' => $news->commonId], true)?>
        </a></small>
    <?php endif; ?>
</div>

<div class="form-horizontal clearfix">
    <ul class="nav nav-tabs">
        <?php foreach (\yii::$app->params['languages'] as $langKey => $langVal): ?>
            <li class="<?=$news->lang === $langKey ? 'active' : ''?>">
                <a href="<?=Url::toRoute([
                    'edit',
                    'id'    => $news->commonId,
                    'lang'  => $langKey,
                ])?>"><?=$langVal?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <br />
    <input type="hidden" name="id" value="<?=$news->commonId?>" />
    <input type="hidden" name="lang" value="<?=$news->lang?>" />
    <div class="row">
        <div class="col-md-12">
            <div class="form-group" id="uploadImagesContainer"
                 data-images-limit="<?=\common\models\News::MAX_IMAGES_COUNT?>"
                 data-confirm-text="<?=\yii::t('app', 'Are you sure you want to delete this image?')?>">
                <div style="position: relative">
                    <button class="btn btn-primary btn-upload <?= (count($newsImages) >= \common\models\News::MAX_IMAGES_COUNT) ? 'hide' : ''?>" id="uploadNewsImages">
                        <b><?=\yii::t('app', 'Upload images')?></b>
                    </button>
                    <div class="help-block"></div>
                </div>
                <div class="images-block" style="display: inline-block">
                    <div class="news-edit__image-item hide">
                        <img alt="" width="75" height="auto"><br/>
                        <button class="btn btn-link" data-confirm="<?=\yii::t('app', 'Are you sure you want to delete this image?')?>">delete</button>
                    </div>
                    <?php foreach($newsImages as $imageId): ?>
                        <div class="news-edit__image-item" data-image-id="<?=$imageId?>">
                            <img src="<?=Url::toRoute(['/news/image', 'id' => $imageId])?>" alt="" />
                            <br />
                            <button class="btn btn-link" data-confirm="<?=\yii::t('app', 'Are you sure you want to delete this image?')?>">
                                <?=\yii::t('app', 'delete')?>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
    <div class="form-group">
        <?= \frontend\widgets\user\GeoFilter::widget(['checked' => $news->geo]) ?>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="title" value="<?=Html::encode($news->title)?>" placeholder="<?=\yii::t('app', 'Title')?>">
    </div>
    <div class="form-group">
        <textarea class="form-control" name="content" style="height: 500px;"><?=Html::encode($news->content)?></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary save-news btn-lg pull-left" disabled="">
            <?=\yii::t('app', 'Save News')?>
        </button>
        <div class="pull-right">
            <?= \frontend\widgets\news\StatusSwitcher::widget(['news' => $news, 'btnSize' => 'btn-lg']) ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffNewsEdit();
    });
</script>
