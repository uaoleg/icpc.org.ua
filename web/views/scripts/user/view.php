<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <h3>
            <?=\web\widgets\user\Name::create(array('user' => $user), true)?>
        </h3>
        <h4>
            <?php if (isset($user->school->{'fullName' . ucfirst(\yii::app()->language)})): ?>
                <?=$user->school->{'fullName' . ucfirst(\yii::app()->language)}?>
            <?php else: ?>
                <?=$user->schoold->fullNameUk?>
            <?php endif; ?>
        </h4>

        <div class="row">
            <div class="col-lg-6">
                <h4><?=\yii::t('app', 'Teams')?></h4>
                <div class="list-group">
                    <?php foreach ($teams as $team): ?>
                        <a href="<?=$this->createUrl('/team/view', array('id' => (string)$team->_id))?>" class="list-group-item">
                            <?=$team->name?>&nbsp;<span class="badge"><?=$team->year?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>