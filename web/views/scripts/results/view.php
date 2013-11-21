<div class="page-header">
    <h1><?=$header?> <small><?=$year?>, <?=\yii::t('app', 'phase')?> <?=$phase?></small></h1>
</div>

<?php if (count($results) > 0): ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th><?=\yii::t('app', 'Place')?></th>
                <th><?=\yii::t('app', 'Team name')?></th>
                <?php for ($i = 0; $i < $tasksCount; $i++): ?>
                <th><?=$letters[$i]?></th>
                <?php endfor; ?>
                <th><?=\yii::t('app', 'Total')?></th>
                <th><?=\yii::t('app', 'Penalty')?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($results as $result): ?>
                <tr>
                    <td><?=\CHtml::encode($result->place)?></td>
                    <td>
                        <a href="<?=$this->createUrl('/team/view', array('id' => $result->team->_id))?>">
                            <?=\CHtml::encode($result->team->name)?>
                        </a>
                    </td>
                    <?php foreach ($result->tasksTries as $try): ?>
                        <td><?=\CHtml::encode($try)?></td>
                    <?php endforeach; ?>
                    <td><?=\CHtml::encode($result->total)?></td>
                    <td><?=\CHtml::encode($result->penalty)?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
<?php else: ?>
    <div class="alert alert-info">
        <?=\yii::t('app', 'Sorry but results are not available yet.')?>
    </div>
<?php endif; ?>