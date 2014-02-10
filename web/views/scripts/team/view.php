<?php use \common\models\User; ?>

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
        <?php \web\widgets\user\Name::create(array('user' => $coach)); ?>
        <br />
        <strong><?=\yii::t('app', 'School')?></strong>:
        <?=\CHtml::encode($team->school->fullNameUk)?>
        <br />
        <?php if(isset($team->league)): ?>
            <strong><?=\yii::t('app', 'League')?></strong>:
            <?php if(\yii::app()->user->checkAccess(\common\components\Rbac::OP_TEAM_LEAGUE_UPDATE) && $team->phase === \common\models\Result::PHASE_3):?>
                <div class="btn-group">
                    <a href="<?=$this->createUrl('/staff/team/leagueUpdate', array('team' => (string)$team->_id, 'league' => \common\models\Team::LEAGUE_I))?>"
                       class="btn btn-default <?= ($team->league === \common\models\Team::LEAGUE_I) ? 'active' : ''?>">
                        <?=\common\models\Team::LEAGUE_I?>
                    </a>
                    <a href="<?=$this->createUrl('/staff/team/leagueUpdate', array('team' => (string)$team->_id, 'league' => \common\models\Team::LEAGUE_II))?>"
                       class="btn btn-default <?= ($team->league === \common\models\Team::LEAGUE_II) ? 'active' : ''?>">
                        <?=\common\models\Team::LEAGUE_II?>
                    </a>
                </div>
            <?php else: ?>
                <?=\CHtml::encode($team->league)?>
            <?php endif; ?>
            <br />
        <?php endif; ?>
        <strong><?=\yii::t('app', 'Participants')?></strong>:
        <ul>
            <?php foreach ($members as $member): ?>
            <li><?php \web\widgets\user\Name::create(array('user' => $member)); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php if (count($results)): ?>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h2><?=\yii::t('app', 'Results')?></h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><?=\yii::t('app', 'Place')?></th>
                        <th><?=\yii::t('app', 'Stage')?></th>
                        <th><?=\yii::t('app', 'Total')?></th>
                        <th><?=\yii::t('app', 'Penalty')?></th>
                        <th><?=\yii::t('app', 'Details')?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($results as $result): ?>
                        <tr>
                            <td>
                                <?=$result->place?>
                                <?php if ($result->prizePlace < \common\models\Result::PRIZE_PLACE_NO): ?>
                                    (<?=$result->prizePlace?>)
                                <?php endif; ?>
                            </td>
                            <td><?=$result->phase?></td>
                            <td><?=$result->total?></td>
                            <td><?=$result->penalty?></td>
                            <td>
                                <a href="<?=$this->createUrl('/results/view', array(
                                    'year'              => $result->year,
                                    'phase'             => $result->phase,
                                    $result->geoType    => $result->geo,
                                ))?>"><?=\yii::t('app', 'View')?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>