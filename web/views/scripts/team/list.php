<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <table class="table table-striped table-hover table-bordered">
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