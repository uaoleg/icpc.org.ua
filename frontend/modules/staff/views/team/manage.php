<?php

/* @var $this   \yii\web\View */
/* @var $team   \common\models\Team */
/* @var $users  \common\models\User[] */
/* @var $school \common\models\School */

use \common\models\Result;
use \common\models\User;
use \common\models\Team;
use \yii\helpers\Html;

?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffTeamManage({
            teamId: '<?=$team->id?>'
        });
    });
</script>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <div class="panel panel-primary panel-school">
            <div class="panel-heading">
                <?=\yii::t('app', 'Team Info (out of competition)')?>
            </div>

            <div class="panel-body form">

                <div class="form-group">
                    <p class="form-control-static"><strong><?=\yii::t('app', 'Year')?></strong>: <?=$team->year?></p>
                </div>

                <div class="form-group">
                    <p class="form-control-static">
                        <strong><?=\yii::t('app', 'School')?></strong>:
                        <?=$school->fullName?>
                    </p>
                </div>

                <hr/>

                <div class="form-group">
                    <label for="name"><?=\yii::t('app', 'Name of a team')?></label>
                    <input type="text" class="form-control" id="name" name="name"
                           data-prefix="<?=Html::encode($school->shortNameEn)?>"
                           value="<?=(!empty($team->name)) ? Html::encode($team->name) : Html::encode($school->shortNameEn)?>"
                           placeholder="<?=\yii::t('app', 'Name of your team')?>">
                </div>

                <?php if (\yii::$app->user->can(User::ROLE_COORDINATOR_STATE) && $team->phase === Result::PHASE_3): ?>
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
                        <?php foreach ($users as $user): ?>
                            <option value="<?=$user->id?>" <?=$team->hasMember($user->id) ? 'selected' : ''?>>
                                <?= \frontend\widgets\user\Name::widget(['user' => $user]) ?>
                                <?= Html::encode($user->email)?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="alert alert-warning" role="alert">
                    <?=\yii::t('app', 'Note, that this team will be <b>out of</b> competition. To create a team in competition, please import it from icpc.baylor.edu')?>
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