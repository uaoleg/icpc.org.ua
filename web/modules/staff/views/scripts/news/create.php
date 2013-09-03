<?php \yii::app()->getClientScript()->registerCoreScript('ckeditor'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffNewsCreate();
    });
</script>

<div class="page-header clearfix">
    <h1>
        <?=\yii::t('app', 'Create News')?>
    </h1>
</div>
<div class="form-horizontal clearfix">
    <div class="form-group">
        <select class="form-control lang">
            <?php foreach (\yii::app()->params['languages'] as $langKey => $langVal): ?>
            <option value="<?=$langKey?>" <?=$langKey === \yii::app()->language ? 'selected' : ''?>>
                <?=$langVal?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
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
    </div>
</div>