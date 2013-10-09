<div class="col-lg-offset-4 col-lg-5">

    <?php if (!empty($user->coordinator)): ?>
        <?php if (\yii::app()->user->checkAccess(\common\models\User::ROLE_COORDINATOR)): ?>
            <div class="alert alert-success">
                <?=\yii::t('app', 'You are approved coordinator.')?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                <?=\yii::t('app', 'Waiting approval of coordinator request.')?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

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
                <?=$user->type?>
            </td>
        </tr>
    </table>

</div>
