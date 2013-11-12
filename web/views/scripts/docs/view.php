<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?=\CHtml::encode($document->title)?>
            </div>
            <div class="panel-body">
                <p>
                    <?php if (!empty($document->desc)): ?>
                        <?=\CHtml::encode($document->desc)?>
                    <?php else: ?>
                        <i><?=\yii::t('app', 'No description')?></i>
                    <?php endif; ?>
                </p>
            </div>
            <div class="panel-footer">
                <a href="<?=$this->createUrl('download', array('id' => $document->_id))?>">
                    <?=\yii::t('app', 'Download')?></a>
                <span class="document-size"><?php \web\widgets\document\Size::create(array('document' => $document)); ?></span>
            </div>
        </div>
    </div>
</div>