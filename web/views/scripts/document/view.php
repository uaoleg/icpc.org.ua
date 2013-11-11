<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?=\CHtml::encode($document->title)?>
            </div>
            <div class="panel-body">
                <p>
                    <?=\CHtml::encode($document->desc)?>
                </p>
                <?=$sizeLabel?>
            </div>
            <div class="panel-footer">
                <a href="<?=$this->createUrl('/docs/download', array('id' => $document->_id))?>">
                    <?=\yii::t('app', 'Download')?>
                </a>
            </div>
        </div>
    </div>
</div>