<div style="margin: 5px 0;">
    <button type="button" class="btn btn-success student-state <?=$user->isApprovedStudent ? 'hide' : ''?>"
        <?=(\yii::app()->user->checkAccess(\common\components\Rbac::OP_STUDENT_SET_STATUS)) ? '' : 'disabled'?>
            data-state="1" data-uid="<?=$user->_id?>">
        <?=\yii::t('app', 'Activate')?>
    </button>
    <button type="button" class="btn btn-danger student-state <?=$user->isApprovedStudent ? '' : 'hide'?>"
        <?=(\yii::app()->user->checkAccess(\common\components\Rbac::OP_STUDENT_SET_STATUS)) ? '' : 'disabled'?>
            data-state="0" data-uid="<?=$user->_id?>">
        <?=\yii::t('app', 'Suspend')?>
    </button>
</div>