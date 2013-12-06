<?php
    use \common\models\Document;
    \yii::app()->getClientScript()->registerCoreScript('plupload');
?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffDocsEdit();
    });
</script>

<div class="page-header clearfix">
    <h1>
        <?=\yii::t('app', 'Document')?>
    </h1>
    <?php if (!$document->isNewRecord): ?>
        <small><a href="<?=$this->createUrl('/docs/view', array('id' => $document->_id))?>" target="_blank">
            <?=$this->createAbsoluteUrl('/docs/view', array('id' => $document->_id))?>
        </a></small>
    <?php endif; ?>
</div>
<div class="form-horizontal clearfix">
    <input type="hidden" name="id" value="<?=$document->_id?>" />
    <div class="form-group">
        <?php if ($document->isNewRecord): ?>
            <div id="container" style="position: relative;">
                <button type="button" class="btn btn-primary" id="pickfiles">
                    <?=\yii::t('app', 'Upload')?>
                </button>
                <span class="document-origin-filename"></span>
                <div class="help-block"></div>
            </div>
        <?php else: ?>
            <button type="button" class="btn btn-primary" disabled="">
                <?=\yii::t('app', 'Uploaded')?>
            </button>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="title" value="<?=\CHtml::encode($document->title)?>" placeholder="<?=\yii::t('app', 'Title')?>">
    </div>
    <div class="form-group">
        <textarea class="form-control" name="desc"><?=\CHtml::encode($document->desc)?></textarea>
    </div>
    <div class="form-group">
        <select class="form-control" name="type">
            <?php foreach (Document::model()->getConstantList('TYPE_') as $type): ?>
            <option value="<?=$type?>" <?=($type === $document->type) ? 'selected' : ''?>>
                <?=Document::model()->getAttributeLabel($type, 'type')?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary save-document btn-lg pull-left" disabled="">
            <?=\yii::t('app', 'Save Document')?>
        </button>
        <?php if (!$document->isNewRecord): ?>
            <div class="pull-right">

            </div>
        <?php endif; ?>
    </div>
</div>