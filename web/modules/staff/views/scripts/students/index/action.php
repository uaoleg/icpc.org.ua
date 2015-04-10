<div style="margin: 5px 0;">
    <button type="button" class="btn btn-success student-state <?=$user->isApprovedStudent ? 'hide' : ''?>"
        <?=(\yii::app()->user->checkAccess(\common\components\Rbac::OP_STUDENT_SET_STATUS)) ? '' : 'disabled'?>
            data-state="1" data-uid="<?=$user->_id?>">
        <?php
            $message = (\yii::app()->user->checkAccess(\common\models\User::ROLE_COORDINATOR_STATE)) ? 'Undo' : 'Activate';
            echo \yii::t('app', $message);
        ?>
    </button>
    <button type="button" class="btn btn-danger student-state <?=$user->isApprovedStudent ? '' : 'hide'?>"
        <?=(\yii::app()->user->checkAccess(\common\components\Rbac::OP_STUDENT_SET_STATUS)) ? '' : 'disabled'?>
            data-state="0" data-uid="<?=$user->_id?>">
        <?php
            $message = (\yii::app()->user->checkAccess(\common\models\User::ROLE_COORDINATOR_STATE)) ? 'Delete' : 'Suspend';
            echo \yii::t('app', $message);
        ?>
    </button>
</div>