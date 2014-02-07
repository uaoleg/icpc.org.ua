<?php use \common\models\Result; ?>
<?php use \common\models\User; ?>
<?php use \common\models\Team; ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffTeamManage({
            teamId: '<?=$team->_id?>'
        });
    });
</script>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <div class="panel panel-primary panel-school">
            <div class="panel-heading">
                <?=\yii::t('app', 'Team Info')?>
            </div>

            <div class="panel-body form">

                <div class="form-group">
                    <p class="form-control-static"><b><?=$team->year?></b>&nbsp;<?=\yii::t('app', 'year')?></p>
                </div>

                <div class="form-group">
                    <p class="form-control-static"><?=\CHtml::encode($school->fullNameUk)?></p>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="shortNameUk"
                           placeholder="<?=\yii::t('app', 'Short name of university (ukrainian)')?>"
                           value="<?=\CHtml::encode($school->shortNameUk)?>"
                           <?=(!empty($school->shortNameUk)) ? ' disabled' : ''?>>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="fullNameEn"
                           placeholder="<?=\yii::t('app', 'Full name of university (english)')?>"
                           value="<?=\CHtml::encode($school->fullNameEn)?>"
                           <?=(!empty($school->fullNameEn)) ? ' disabled' : ''?>>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="shortNameEn"
                           placeholder="<?=\yii::t('app', 'Short name of university (english)')?>"
                           value="<?=\CHtml::encode($school->shortNameEn)?>"
                           <?=(!empty($school->shortNameEn)) ? ' disabled' : ''?>>
                </div>

                <hr>

                <div class="form-group">
                    <label for="name"><?=\yii::t('app', 'Name of a team')?></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?=\CHtml::encode(substr($team->name, strlen($school->shortNameEn)))?>"
                           placeholder="<?=\yii::t('app', 'Name of your team')?>"/>
                </div>

                <div class="form-group">
                    <label for="teamNamePrefix"><?=\yii::t('app', 'Full name preview')?></label>
                    <input type="text" class="form-control" id="teamNamePrefix" name="teamNamePrefix"
                           value="<?=\CHtml::encode($team->name)?>"
                           placeholder="<?=\yii::t('app', 'Name of your team with prefix')?>" readonly/>
                </div>

                <?php if (\yii::app()->user->checkAccess(User::ROLE_COORDINATOR_STATE) && $team->phase === Result::PHASE_3): ?>
                    <div class="form-group">
                        <label for="teamLeague"><?=\yii::t('app', 'League')?></label><br/>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?= ($team->league === Team::LEAGUE_I) ? 'active' : ''?>">
                                <input type="radio" name="league" value="I"> <?=Team::LEAGUE_I?>
                            </label>
                            <label class="btn btn-default <?= ($team->league === Team::LEAGUE_II) ? 'active' : ''?>">
                                <input type="radio" name="league" value="II"> <?=Team::LEAGUE_II?>
                            </label>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="memberIds"><?=\yii::t('app', 'Members')?></label>
                    <select name="memberIds" id="memberIds" class="form-control" multiple>
                        <?php foreach($users as $user): ?>
                            <option value="<?=$user->_id?>" <?=(in_array((string)$user->_id, $team->memberIds)) ? 'selected' : ''?>>
                                <?php \web\widgets\user\Name::create(array('user' => $user)); ?>
                                <?=\CHtml::encode($user->email)?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-save">
                        <?=\yii::t('app', 'Save')?>
                    </button>
                </div>

            </div>
        </div>

    </div>

</div>