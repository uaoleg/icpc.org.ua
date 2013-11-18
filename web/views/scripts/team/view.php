<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <h1>
            <?=\CHtml::encode($team->name)?>
            <?php if ($team->coachId === \yii::app()->user->id): ?>
                <a href="<?=$this->createUrl('staff/team/manage', array('id' => $team->_id))?>" class="btn btn-primary"><?=\yii::t('app', 'Manage')?></a>
            <?php endif; ?>
        </h1>
        <h3><?=$team->year?></h3>
        <strong><?=\yii::t('app', 'Coach')?></strong>:
        <?=\CHtml::encode($coach->firstName)?> <?=\CHtml::encode($coach->lastName)?>
        <br />
        <strong><?=\yii::t('app', 'School')?></strong>:
        <?=\CHtml::encode($team->school->fullNameUk)?>
        <br />
        <strong><?=\yii::t('app', 'Participants')?></strong>:
        <ul>
            <?php foreach ($members as $member): ?>
            <li><?=\CHtml::encode($member->firstName)?>&nbsp;
                <?=\CHtml::encode($member->middleName)?>&nbsp;
                <?=\CHtml::encode($member->lastName)?></li>
            <?php endforeach; ?>
        </ul>


    </div>
</div>