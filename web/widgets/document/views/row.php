<div class="clearfix document" style="margin-bottom: 20px;" data-id="<?=$this->document->_id?>">
    <div class="pull-left">
        <?php \web\widgets\document\Icon::create(array('document' => $this->document)); ?>
    </div>
    <div class="pull-left">
        <a href="<?=$this->createUrl('/docs/download', array('id' => $this->document->_id))?>" class="document-title">
            <?=$this->document->title?></a>
        <span class="document-size"><?=$sizeLabel?></span>
        <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_DOCUMENT_UPDATE)): ?>
            <a href="<?=$this->createUrl('/staff/docs/edit', array(
                'id' => $this->document->_id,
            ))?>" class="btn btn-info btn-xs"><?=\yii::t('app', 'Edit')?></a>
        <?php endif; ?>
        <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_DOCUMENT_DELETE)): ?>
            <button class="btn btn-danger btn-xs document-delete"
                    data-confirm="<?=\yii::t('app', 'Are you sure?')?>">
                <?=\yii::t('app', 'Delete')?>
            </button>
        <?php endif; ?>
        <p class="document-desc"><?=$this->document->desc?></p>
    </div>
</div>