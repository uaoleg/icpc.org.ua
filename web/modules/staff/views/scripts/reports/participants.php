<table width="100%" border="1">
    <thead>
        <tr>
            <th rowspan="2">№</th>
            <th rowspan="2"><?=\yii::t('app', 'University full name (ukrainian and english), team name')?></th>
            <th colspan="2"><?=\yii::t('app', 'Full names of students and coach')?></th>
            <th rowspan="2"><?=\yii::t('app', 'E-mail')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Phone number (mobile, home, work)')?></th>
            <th rowspan="2"><?=\yii::t('app', 'T-shirt size')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Year of birth')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Admission year')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Year')?></th>
        </tr>
        <tr>
            <th><?=\yii::t('app', 'Ukrainian language')?></th>
            <th><?=\yii::t('app', 'English language')?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach($participants as $participant): ?>
            <tr>
                <td rowspan="4"><?=$i++?></td>
                <td rowspan="4">
                    <p>
                        <?=$participant['schoolNameUk']?><br/><br/>
                        <?=$participant['schoolNameEn']?><br/><br/>
                        <strong><?=$participant['teamName']?></strong>
                    </p>
                </td>
                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['members'][0])); ?>
            </tr>
            <tr>
                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['members'][1])); ?>
            </tr>
            <tr>
                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['members'][2])); ?>
            </tr>
            <tr>
                <?php $this->renderPartial('partial/participants/person', array('member'=> $participant['coach'])); ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
