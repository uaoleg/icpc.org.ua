<?php

use \common\models\Document;
use \yii\helpers\Html;
use \yii\helpers\Url;

$this->registerJsFile('@web/lib/plupload-834/js/plupload.full.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/lib/plupload-834/js/jquery.plupload.queue/jquery.plupload.queue.min.js', ['position' => \yii\web\View::POS_HEAD]);

?>

<div class="page-header clearfix">
    <h1>
        <?=\yii::t('app', 'Document')?>
    </h1>
    <?php if (!$document->isNewRecord): ?>
        <small><a href="<?=Url::toRoute(['/docs/view', 'id' => $document->id])?>" target="_blank">
            <?=Url::toRoute(['/docs/view', 'id' => $document->id], true)?>
        </a></small>
    <?php endif; ?>
</div>
<div class="form-horizontal clearfix">
    <input type="hidden" name="id" value="<?=$document->id?>" />
    <div class="form-group">
        <?php if ($document->isNewRecord): ?>
            <div id="container" style="position: relative;">
                <button type="button" class="btn btn-primary" id="pickfiles">
                    <?=\yii::t('app', 'Choose file')?>
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
        <input type="text" class="form-control" name="title" value="<?=Html::encode($document->title)?>" placeholder="<?=\yii::t('app', 'Title')?>">
    </div>
    <div class="form-group">
        <textarea class="form-control" name="desc"><?=Html::encode($document->desc)?></textarea>
    </div>
    <div class="form-group">
        <select class="form-control" name="type">
            <?php foreach (Document::getConstants('TYPE_') as $type): ?>
            <option value="<?=$type?>" <?=($type === $document->type) ? 'selected' : ''?>>
                <?=Document::getConstantLabel($type)?>
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

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffDocsEdit();
    });
</script>
