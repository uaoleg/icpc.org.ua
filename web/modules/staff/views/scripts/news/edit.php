<?php \yii::app()->getClientScript()->registerCoreScript('ckeditor'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffNewsEdit();
    });
</script>

<div class="page-header clearfix">
    <?php if (empty($news->commonId)): ?>
        <h1><?=\yii::t('app', 'Create News')?></h1>
    <?php else: ?>
        <h1><?=\yii::t('app', 'Edit News')?></h1>
        <small><b><?=\yii::t('app', 'Preview')?>:</b> <a href="<?=$this->createUrl('/news/view', array(
            'id'    => $news->commonId,
            'lang'  => $news->lang,
        ))?>" target="_blank">
            <?=$this->createAbsoluteUrl('/news/view', array('id' => $news->commonId))?>
        </a></small>
    <?php endif; ?>
</div>
<div class="form-horizontal clearfix">
    <ul class="nav nav-tabs">
        <?php foreach (\yii::app()->params['languages'] as $langKey => $langVal): ?>
            <li class="<?=$news->lang === $langKey ? 'active' : ''?>">
                <a href="<?=$this->createUrl('edit', array(
                    'id'    => $news->commonId,
                    'lang'  => $langKey,
                ))?>"><?=$langVal?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <br />
    <input type="hidden" name="id" value="<?=$news->commonId?>" />
    <input type="hidden" name="lang" value="<?=$news->lang?>" />
    <div class="form-group">
        <small><a href="http://postimage.org/index.php?um=computer&content=family" target="_blank">
            <b><?=\yii::t('app', 'Upload images here')?></b>
        </a></small>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="title" value="<?=\CHtml::encode($news->title)?>" placeholder="<?=\yii::t('app', 'Title')?>">
    </div>
    <div class="form-group">
        <textarea class="form-control" name="content" style="height: 500px;"><?=\CHtml::encode($news->content)?></textarea>
    </div>
    <div class="form-group">
        <button class="btn btn-primary save-news btn-lg pull-left" disabled="">
            <?=\yii::t('app', 'Save News')?>
        </button>
        <div class="pull-right">
            <?php \web\widgets\news\StatusSwitcher::create(array('news' => $news)); ?>
        </div>
    </div>
</div>