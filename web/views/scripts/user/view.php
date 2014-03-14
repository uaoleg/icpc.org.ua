<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <h3>
            <?=\web\widgets\user\Name::create(array('user' => $user), true)?>
        </h3>
        <h4>
            <?php if (isset($user->school->{'fullName' . ucfirst(\yii::app()->language)})): ?>
                <?=$user->school->{'fullName' . ucfirst(\yii::app()->language)}?>
            <?php else: ?>
                <?=$user->school->fullNameUk?>
            <?php endif; ?>
        </h4>

        <?php if (count($fullViewAttrs) > 0): ?>
            <div class="row">
                <div class="col-lg-12">
                    <?php foreach ($fullViewAttrs as $attribute): ?>
                        <?php if (isset($user->info->$attribute) && !empty($user->info->$attribute)): ?>
                            <?=$user->getAttributeLabel($attribute)?>:&nbsp;<?=$user->info->$attribute?><br></br>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (count($teams) > 0): ?>
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
        <?php endif; ?>
    </div>
</div>