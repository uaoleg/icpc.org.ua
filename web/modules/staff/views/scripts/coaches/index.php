<?php
    use \common\components\Rbac;
    use \common\models\User;
?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffCoachesIndex();
    });
</script>

<h3><?=\yii::t('app', 'List of Coaches')?></h3>

<table class="table">
    <thead>
        <tr>
            <th><?=\yii::t('app', 'Name')?></th>
            <th><?=\yii::t('app', 'Email')?></th>
            <th><?=\yii::t('app', 'Registration date')?></th>
            <th><?=\yii::t('app', 'Action')?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userList as $user): ?>
            <tr data-id="<?=$user->_id?>">
                <td style="vertical-align: middle;">
                    <a href="<?=$this->createUrl('/user/view', array('id' => (string)$user->_id))?>">
                        <?php \web\widgets\user\Name::create(array('user' => $user)); ?>
                    </a>
                </td>
                <td style="vertical-align: middle;"><?=$user->email?></td>
                <td style="vertical-align: middle;"><?=date('Y-m-d H:i:s', $user->dateCreated)?></td>
                <td style="width: 200px;">
                    <button type="button" class="btn btn-success coach-state <?=$user->isApprovedCoach ? 'hide' : ''?>"
                            <?=(\yii::app()->user->checkAccess(Rbac::OP_COACH_SET_STATUS, array('user' => $user))) ? '' : 'disabled'?>
                            data-state="1">
                        <?=\yii::t('app', 'Activate')?>
                    </button>
                    <button type="button" class="btn btn-danger coach-state <?=$user->isApprovedCoach ? '' : 'hide'?>"
                            <?=(\yii::app()->user->checkAccess(Rbac::OP_COACH_SET_STATUS, array('user' => $user))) ? '' : 'disabled'?>
                            data-state="0">
                        <?=\yii::t('app', 'Suspend')?>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>