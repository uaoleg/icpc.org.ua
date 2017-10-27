<?php

/* @var $this       \yii\web\View */
/* @var $checked    string */

use \common\models\User;
use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div class="btn-group" data-toggle="buttons">
    <label class="btn btn-default">
        <input type="radio" name="filter-geo" value="<?=$school->country?>"
               <?=\yii::$app->user->can(User::ROLE_COORDINATOR_UKRAINE) ? '' : 'disabled'?> />
        <?=$school->countryLabel?>
    </label>
    <label class="btn btn-default">
        <input type="radio" name="filter-geo" value="<?=$school->region?>"
               <?=\yii::$app->user->can(User::ROLE_COORDINATOR_REGION) ? '' : 'disabled'?> />
        <?=$school->regionLabel?>
    </label>
    <label class="btn btn-default">
        <input type="radio" name="filter-geo" value="<?=$school->state?>"
               <?=\yii::$app->user->can(User::ROLE_COORDINATOR_STATE) ? '' : 'disabled'?> />
        <?=$school->stateLabel?>
    </label>
</div>

<script type="text/javascript">
    <?php if ($checked): ?>
        $('input[name=filter-geo][value=<?=$checked?>]:radio:not([disabled])').click();
    <?php else: ?>
        $('input[name=filter-geo]:radio:not([disabled]):first').click();
    <?php endif; ?>
</script>
