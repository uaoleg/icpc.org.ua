<?php $isAdmin = \yii::app()->user->checkAccess(User::ROLE_ADMIN); ?>

<div style="margin: 5px 0;">
    <button type="button" class="btn btn-success student-state <?=$user->isApprovedStudent ? 'hide' : ''?>"
        <?=(\yii::app()->user->checkAccess(\common\components\Rbac::OP_STUDENT_SET_STATUS)) ? '' : 'disabled'?>
            data-state="1" data-uid="<?=$user->_id?>">
        <?= $isAdmin ? \yii::t('app', 'Activate') : \yii::t('app', 'Undo') ?>
    </button>
    <button type="button" class="btn btn-danger student-state <?=$user->isApprovedStudent ? '' : 'hide'?>"
        <?=(\yii::app()->user->checkAccess(\common\components\Rbac::OP_STUDENT_SET_STATUS)) ? '' : 'disabled'?>
            data-state="0" data-uid="<?=$user->_id?>">
        <?= $isAdmin ? \yii::t('app', 'Suspend') : \yii::t('app', 'Delete') ?>
    </button>
</div>