<?php
    \yii::app()->getClientScript()->registerCoreScript('ckeditor');
    \yii::app()->getClientScript()->registerCoreScript('select2');
?>

<script type="text/javascript">
    $(document).ready(function() {
        new appQaManage();
    });
</script>

<?php if ($question->isNewRecord): ?>
    <h2><?=\yii::t('app', 'Create a new question')?></h2>
<?php else: ?>
    <h2><?=\yii::t('app', 'Edit the question')?></h2>
    <small>
        <b><?=\yii::t('app', 'Preview')?>:&nbsp;</b>
        <a href="<?=$this->createUrl('view', array('id' => $question->_id))?>" target="_blank"></a>
    </small>
<?php endif; ?>

<div class="form-horizontal">
    <input type="hidden" name="id" value="<?=$question->_id?>" />
    <div class="form-group">
        <input type="text" class="form-control" name="title"
               value="<?=\CHtml::encode($question->title)?>"
               placeholder="<?=\yii::t('app', 'Title')?>">
    </div>
    <div class="form-group">
        <textarea class="form-control"
                  name="content"
                  id="question-content"
                  style="height: 500px;"><?=\CHtml::encode($question->content)?></textarea>
    </div>
    <div class="form-group">
        <input type="text"
               name="tagList"
               value="<?=implode(',', $question->tagList)?>"
               placeholder="<?=\yii::t('app', 'List of tags')?>" />
    </div>
    <div class="form-group">
        <button class="btn btn-primary btn-lg question-save">
            <?=\yii::t('app', 'Save question')?>
        </button>
    </div>
</div>
