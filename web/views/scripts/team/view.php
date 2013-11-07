<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <h1>
            <?=$team->name?>
            <?php if ($team->coachId === \yii::app()->user->id): ?>
                <a href="<?=$this->createUrl('team/manage/id/' . $team->_id)?>" class="btn btn-primary"><?=\yii::t('app', 'Manage')?></a>
            <?php endif; ?>
        </h1>
        <h3><?=$team->year?></h3>
        <strong><?=\yii::t('app', 'Coach')?></strong>: <?=$coach->firstName?>&nbsp;<?=$coach->lastName?><br>
        <strong><?=\yii::t('app', 'School')?></strong>: <?=$school->fullNameUk?>
        <strong><?=\yii::t('app', 'Participants')?></strong>:
        <ul>
            <?php foreach ($members as $member): ?>
            <li><?=$member->firstName?></li>
            <?php endforeach; ?>
        </ul>


    </div>
</div>