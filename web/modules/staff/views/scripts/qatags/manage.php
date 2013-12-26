<?php \yii::app()->getClientScript()->registerCoreScript('ckeditor'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffQatagsManage();
    });
</script>

<h2><?=\yii::t('app', 'Tag Manage')?></h2>

<hr/>

<div class="form-horizontal clearfix">
    <input type="hidden" name="id" value="<?=$tag->_id?>" />
    <div class="form-group">
        <input type="text"
               class="form-control"
               name="name"
               value="<?=\CHtml::encode($tag->name)?>"
               placeholder="<?=\yii::t('app', 'Title')?>">
    </div>
    <div class="form-group">
        <textarea class="form-control"
                  name="desc"
                  id="tag-desc"
                  placeholder="<?=\yii::t('app', 'Description')?>"
                  style="height: 500px;">
            <?=\CHtml::encode($tag->desc)?>
        </textarea>
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-primary save-tag btn-lg">
            <?=\yii::t('app', 'Save')?>
        </button>
    </div>
</div>
