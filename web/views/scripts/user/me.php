<div class="col-lg-offset-4 col-lg-5">

    <table class="table table-bordered">
        <tr>
            <td>
                <?=\yii::t('app', 'Name')?>
            </td>
            <td>
                <?=$user->firstName?> <?=$user->lastName?>
            </td>
        </tr>
        <tr>
            <td>
                <?=\yii::t('app', 'Email')?>
            </td>
            <td>
                <?=$user->email?>
            </td>
        </tr>
        <tr>
            <td>
                <?=\yii::t('app', 'User status')?>
            </td>
            <td>
                <?php if (!empty($user->type)): ?>
                    <?=$user->type?>
                <?php endif; ?>
                <?php if ($user->type === \common\models\User::ROLE_COACH): ?>
                    <?php if ($user->isApprovedCoach): ?>
                        <span class="label label-success">
                            <?=\yii::t('app', 'Approved')?>
                        </span>
                    <?php else: ?>
                        <span class="label label-warning">
                            <?=\yii::t('app', 'Waiting approval')?>
                        </span>
                    <?php endif; ?>
                    <br />
                <?php endif; ?>
                <?php if (!empty($user->coordinator)): ?>
                    <br />
                    <?=\yii::t('app', 'Coordination')?>: <?=$user->getAttributeLabel($user->coordinator, 'coord')?>
                    <?php if ($user->isApprovedCoordinator): ?>
                        <span class="label label-success">
                            <?=\yii::t('app', 'Approved')?>
                        </span>
                    <?php else: ?>
                        <span class="label label-warning">
                            <?=\yii::t('app', 'Waiting approval')?>
                        </span>
                    <?php endif; ?>
                    <br />
                <?php endif; ?>
            </td>
        </tr>
    </table>

</div>
