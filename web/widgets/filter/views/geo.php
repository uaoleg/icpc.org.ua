<?php use \common\models\User; ?>

<div class="btn-group" data-toggle="buttons">
    <label class="btn btn-default">
        <input type="radio" name="filter-geo" value="<?=$user->school->country?>"
               <?=\yii::app()->user->checkAccess(User::ROLE_COORDINATOR_UKRAINE) ? '' : 'disabled'?> />
        <?=$user->school->countryLabel?>
    </label>
    <label class="btn btn-default">
        <input type="radio" name="filter-geo" value="<?=$user->school->region?>"
               <?=\yii::app()->user->checkAccess(User::ROLE_COORDINATOR_REGION) ? '' : 'disabled'?> />
        <?=$user->school->regionLabel?>
    </label>
    <label class="btn btn-default">
        <input type="radio" name="filter-geo" value="<?=$user->school->state?>"
               <?=\yii::app()->user->checkAccess(User::ROLE_COORDINATOR_STATE) ? '' : 'disabled'?> />
        <?=$user->school->stateLabel?>
    </label>
</div>

<script type="text/javascript">
    <?php if ($this->checked): ?>
            $('input[name=filter-geo][value=<?=$this->checked?>]:radio:not([disabled])').click();
    <?php else: ?>
        $('input[name=filter-geo]:radio:not([disabled]):first').click();
    <?php endif; ?>
</script>
