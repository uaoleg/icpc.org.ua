<?php

/* @var $this   \yii\web\View */
/* @var $team   \common\models\Team */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<?php if ($team && !$team->isDeleted): ?>
    <a href="<?=Url::toRoute(['/team/view', 'id' => $team->id])?>" target="_blank">
        <?=Html::encode($team->name)?>
    </a>
<?php else: ?>
    <?=Html::encode($team->name)?>
    <?php if (\yii::$app->user->can(\common\components\Rbac::OP_RESULT_TEAM_DELETE)): ?>
        <br />
        <a href="#"
           class="js-remove-team"
           style="color: red; font-style: italic;"
           rel="tooltip"
           title="<?=\yii::t('app', 'Remove team from this table of results')?>"
           data-placement="right"
           data-bootbox-confirm="<?=\yii::t('app', 'Are you sure you want to delete the team from results?')?>"
        >
            <?=\yii::t('app', 'remove')?>
        </a>
    <?php endif; ?>
<?php endif; ?>
