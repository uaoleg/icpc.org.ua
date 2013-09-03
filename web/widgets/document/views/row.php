<div class="clearfix document" style="margin-bottom: 20px;">
    <div class="pull-left">
        <?php $this->widget('\web\widgets\document\Icon', array('document' => $this->document)); ?>
    </div>
    <div class="pull-left">
        <a href="<?=$this->createUrl('/docs/download', array('id' => $this->document->_id))?>" class="document-title">
            <?=$this->document->title?>
        </a>
        <span class="document-size"><?=$sizeLabel?></span>
        <?php if (\yii::app()->user->checkAccess('documentUpdate')): ?>
            <a href="<?=$this->createUrl('/staff/docs/edit', array(
                'id' => $this->document->_id,
            ))?>" class="btn btn-link"><?=\yii::t('app', 'Edit')?></a>
        <?php endif; ?>
        <p class="document-desc"><?=$this->document->desc?></p>
    </div>
</div>