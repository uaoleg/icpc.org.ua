<script type="text/javascript">
    $(document).ready(function() {
        new appStaffCoachesIndex();
    });
</script>

<h3><?=\yii::t('app', 'List of Coaches')?></h3>

<table class="table">
    <thead>
        <tr>
            <td><?=\yii::t('app', 'Name')?></td>
            <td><?=\yii::t('app', 'Email')?></td>
            <td><?=\yii::t('app', 'Registration date')?></td>
            <td><?=\yii::t('app', 'Action')?></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userList as $user): ?>
            <tr data-id="<?=$user->_id?>">
                <td><?=$user->lastName?> <?=$user->firstName?></td>
                <td><?=$user->email?></td>
                <td><?=date('Y-m-d H:i:s', $user->dateCreated)?></td>
                <td style="width: 200px;">
                    <button class="btn btn-success coach-state <?=$user->isApprovedCoach ? 'hide' : ''?>"
                            <?=((string)$user->_id === \yii::app()->user->getId()) ? 'disabled' : ''?>
                            data-state="1">
                        <?=\yii::t('app', 'Activate')?>
                    </button>
                    <button class="btn btn-danger coach-state <?=$user->isApprovedCoach ? '' : 'hide'?>"
                            <?=((string)$user->_id === \yii::app()->user->getId()) ? 'disabled' : ''?>
                            data-state="0">
                        <?=\yii::t('app', 'Suspend')?>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>