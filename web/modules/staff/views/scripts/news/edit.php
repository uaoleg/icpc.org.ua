<?php \yii::app()->getClientScript()->registerCoreScript('ckeditor'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffNewsEdit();
    });
</script>

<div class="page-header clearfix">
    <h1>
        <?=\yii::t('app', 'News')?>
    </h1>
    <?php if (!$news->getIsNewRecord()): ?>
        <small><a href="<?=$this->createUrl('/news/view', array('id' => $news->_id))?>" target="_blank">
            <?=$this->createAbsoluteUrl('/news/view', array('id' => $news->_id))?>
        </a></small>
    <?php endif; ?>
</div>
<div class="form-horizontal clearfix">
    <input type="hidden" class="id" value="<?=$news->_id?>" />
    <div class="form-group">
        <input type="text" class="form-control title" value="<?=\CHtml::encode($news->title)?>" placeholder="<?=\yii::t('app', 'Title')?>">
    </div>
    <div class="form-group">
        <textarea class="form-control content" style="height: 500px;"><?=\CHtml::encode($news->content)?></textarea>
    </div>
    <div class="form-group">
        <button class="btn btn-primary save-news btn-lg pull-left" disabled="">
            <?=\yii::t('app', 'Save News')?>
        </button>
        <?php if (!$news->getIsNewRecord()): ?>
            <div class="pull-right">
                <?php $this->widget('\web\widgets\news\StatusSwitcher', array('news' => $news)); ?>
            </div>
        <?php endif; ?>
    </div>
</div>