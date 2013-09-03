<div class="modal hide" id="customer-<?=$action?>-modal">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h3><?=$title?></h3>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="customerSuspendAbuseList"><?=\yii::t('app', 'Abuses')?>:</label>
                <div class="controls">
                    <select id="customerSuspendAbuseList">
                        <option>
                        </option>
                        <?php foreach ($abuseList as $abuse): ?>
                            <option value="<?=$abuse->_id?>"
                                    data-description="<?=$abuse->description?>"
                                    data-date="<?=date('Y-m-d', $abuse->date)?>">
                                <?php $this->widget('\web\models\widgets\customer\FullName', array(
                                    'customer' => $abuse->reporter(),
                                )); ?>:
                                <?=$abuse->reason?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="customerSuspendComment"><?=\yii::t('app', 'Comment')?>:</label>
                <div class="controls">
                    <textarea id="customerSuspendComment"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal">
            <?=\yii::t('app', 'Cancel')?>
        </button>
        <button class="btn btn-info suspend" data-status="<?=$status?>">
            <?=\yii::t('app', 'Done')?>
        </button>
    </div>
</div>
