<?=$result->place?>
<?php if (($result->team !== null) && (\yii::app()->user->checkAccess(\common\components\Rbac::OP_TEAM_UPDATE_PHASE))): ?>
    <input type="checkbox"
           <?=$result->phaseIsCompleted ? 'checked' : ''?>
           class="results-phase-completed"
           title="<?=\yii::t('app', 'Stage is completed')?>"
           rel="tooltip"
           data-placement="right" />
<?php elseif ($result->phaseIsCompleted): ?>
    <span class="glyphicon glyphicon-chevron-down"
           title="<?=\yii::t('app', 'Phase is completed')?>"
           rel="tooltip"
           data-placement="right"></span>
<?php endif; ?>