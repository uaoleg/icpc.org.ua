<table width="100%" border="1">
    <thead>
        <tr>
            <th rowspan="2"><?=\yii::t('app', 'Place')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Team name (in english)')?></th>
            <th rowspan="2"><?=\yii::t('app', 'University full name')?></th>
            <th colspan="2"><?=\yii::t('app', 'Full names of students and coach')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Tasks count')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Total time')?></th>
        </tr>
        <tr>
            <th><?=\yii::t('app', 'Ukrainian language')?></th>
            <th><?=\yii::t('app', 'English language')?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($winners as $winner): ?>
            <tr>
                <td rowspan="<?=count($winner['members']) + 1?>" class="text-center"><?=$winner['place']?></td>
                <td rowspan="<?=count($winner['members']) + 1?>"><?=$winner['teamName']?></td>
                <td rowspan="<?=count($winner['members']) + 1?>" class="text-center"><?=$winner['schoolName']?></td>
                <?php if (count($winner['members'])):?>
                    <?php for ($i = 0; $i < count($winner['members']); $i++): ?>
                        <?php $this->render('partial/winners/person', array('member'=> $winner['members'][$i], 'i' => $i)); ?>

                        <?php if ($i === 0): ?>
                            <td rowspan="<?=count($winner['members']) + 1?>" class="text-center"><?=$winner['tasks']?></td>
                            <td rowspan="<?=count($winner['members']) + 1?>" class="text-center"><?=$winner['totalTime']?></td>
                        <?php endif; ?>
                    <?php endfor; ?>
                <?php else: ?>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td rowspan="<?=count($winner['members']) + 1?>" class="text-center"><?=$winner['tasks']?></td>
                    <td rowspan="<?=count($winner['members']) + 1?>" class="text-center"><?=$winner['totalTime']?></td>
                <?php endif; ?>

                <?php if(isset($winner['coach'])): ?>
                    <?php $this->render('partial/winners/person', array('member'=> $winner['coach'], 'i' => true)); ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
