<?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_TEAM_UPDATE_PHASE)): ?>
    <select class="team-phase">
        <?php foreach (\common\models\Result::model()->getConstantList('PHASE_') as $phase): ?>
        <option <?=($phase === $team->phase) ? 'selected' : ''?>>
            <?=$phase?>
        </option>
        <?php endforeach; ?>
    </select>
<?php else: ?>
    <?=$team->phase?>
<?php endif; ?>
