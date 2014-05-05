<?php if (($result->team !== null) && (!$result->team->isDeleted)): ?>
    <a href="<?=$this->createUrl('/team/view', array('id' => $result->teamId))?>">
        <?=$result->teamName?>
    </a>
<?php else: ?>
    <?=$result->teamName?>
    <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_RESULT_TEAM_DELETE)): ?>
        <br />
        <a href="#"
           class="js-remove-team"
           style="color: red; font-style: italic;"
           rel="tooltip"
           title="<?=\yii::t('app', 'Remove team from this table of results')?>"
           data-placement="right"
           data-confirm="<?=\yii::t('app', 'Are you sure you want to delete the team from results?')?>"
        >
            <?=\yii::t('app', 'remove')?>
        </a>
    <?php endif; ?>
<?php endif; ?>