<?php
    use \common\models\User\Customer as Customer;
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.customer-suspend-reactivate').formsSuspendReactivate();
    });
</script>

<span class="customer-suspend-reactivate" data-customer-id="<?=$this->customer->_id?>">

    <?php if ($this->customer->status !== Customer::STATUS_BANNED): ?>
        <a href="#customer-ban-modal" class="btn" data-toggle="modal">
            <i class="icon-off"></i>
            <?=\yii::t('app', 'Ban')?>
        </a>
        <?php $this->render('partial/suspendModal', array(
            'abuseList' => $abuseList,
            'action'    => 'ban',
            'title'     => \yii::t('app', 'Ban customer'),
            'status'    => Customer::STATUS_BANNED
        ));?>
    <?php endif; ?>

    <?php if ($this->customer->status !== Customer::STATUS_SUSPENDED): ?>
        <a href="#customer-suspend-modal" class="btn" data-toggle="modal" data-status="<?=Customer::STATUS_SUSPENDED?>">
            <i class="icon-off"></i>
            <?=\yii::t('app', 'Suspend')?>
        </a>
        <?php $this->render('partial/suspendModal', array(
            'abuseList' => $abuseList,
            'action'    => 'suspend',
            'title'     => \yii::t('app', 'Suspend customer'),
            'status'    => Customer::STATUS_SUSPENDED
        ));?>
    <?php endif; ?>

    <?php if ($this->customer->status !== Customer::STATUS_ACTIVE): ?>
        <a href="#customer-reactivate-modal" class="btn" data-toggle="modal">
            <i class="icon-leaf"></i>
            <?=\yii::t('app', 'Reactivate')?>
        </a>
        <div class="modal hide" id="customer-reactivate-modal">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h3><?=\yii::t('app', 'Reactivate customer')?></h3>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="customerReactivateComment"><?=\yii::t('app', 'Comment')?>:</label>
                        <div class="controls">
                            <textarea id="customerReactivateComment"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">
                    <?=\yii::t('app', 'Cancel')?>
                </button>
                <button class="btn btn-info reactivate">
                    <?=\yii::t('app', 'Done')?>
                </button>
            </div>
        </div>
    <?php endif; ?>

</span>