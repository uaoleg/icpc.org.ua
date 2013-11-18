<div class="pull-right">
    <?php \web\widgets\filter\Year::create(array('checked' => $year)); ?>
</div>

<?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_TEAM_CREATE)): ?>
    <a class="btn btn-success btn-lg" href="<?=$this->createUrl('/staff/team/manage')?>"><?=\yii::t('app', 'Create a new team')?></a>
    <hr>
<?php endif; ?>

<?php if (count($teams) > 0): ?>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <table class="table table-striped table-hover table-bordered" style="">
                <thead>
                    <tr>
                        <th>
                            <?=\yii::t('app', 'Team name')?>
                        </th>
                    </tr>
                </thead>
                <?php foreach ($teams as $team) : ?>
                    <tr>
                        <td>
                            <a href="<?=$this->createUrl('/team/view', array('id' => $team->_id))?>"><?=\CHtml::encode($team->name)?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

<?php else: ?>

    <div class="alert alert-info">
        <?=\yii::t('app', 'There are no teams.')?>
    </div>

<?php endif; ?>