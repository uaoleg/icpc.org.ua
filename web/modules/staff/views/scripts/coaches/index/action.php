<div style="margin: 5px 0;">
    <button type="button" class="btn btn-success coach-state <?=$user->isApprovedCoach ? 'hide' : ''?>"
        <?=(\yii::app()->user->checkAccess(\common\components\Rbac::OP_COACH_SET_STATUS, array('user' => $user))) ? '' : 'disabled'?>
            data-state="1" data-uid="<?=$user->_id?>">
        <?=\yii::t('app', 'Activate')?>
    </button>
    <button type="button" class="btn btn-danger coach-state <?=$user->isApprovedCoach ? '' : 'hide'?>"
        <?=(\yii::app()->user->checkAccess(\common\components\Rbac::OP_COACH_SET_STATUS, array('user' => $user))) ? '' : 'disabled'?>
            data-state="0" data-uid="<?=$user->_id?>">
        <?=\yii::t('app', 'Suspend')?>
    </button>
</div>