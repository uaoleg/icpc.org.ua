<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <?php if ($user->type == \common\models\User::ROLE_COACH) : ?>
            <a class="btn btn-primary btn-lg" href="<?=$this->createUrl('/team/manage')?>"><?=\yii::t('app', 'Create a new team')?></a>
            <hr>
        <?php endif; ?>

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
                        <a href="<?=$this->createUrl('/team/view/id/' . $team->_id)?>"><?=CHtml::encode($team->name)?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>
</div>