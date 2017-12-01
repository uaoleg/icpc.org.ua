<?php

/* @var $this           \yii\web\View */
/* @var $teamsProvider  \yii\data\ActiveDataProvider */
/* @var $teamsSearch    \frontend\search\TeamSearch */
/* @var $year           int */
/* @var $teamsCount     int */

use \common\models\School;
use \common\models\Team;
use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<table class="page-top-controls"><tr>

    <?php if (\yii::$app->user->can(\common\components\Rbac::OP_TEAM_CREATE)): ?>
    <td>
        <a class="btn btn-success btn-lg"
           href="<?=Url::toRoute(['/staff/team/manage'])?>"
           title="<?=\yii::t('app', 'Create a new team out of competition')?>"
           rel="tooltip">
            <span class="glyphicon glyphicon-plus"></span>
            <?=\yii::t('app', 'New team')?>
        </a>
    </td>
    <td>
        <a class="btn btn-success btn-lg"
           href="<?=Url::toRoute(['/staff/team/import'])?>"
           title="<?=\yii::t('app', 'Import teams from icpc.baylor.edu')?>"
           rel="tooltip">
            <span class="glyphicon glyphicon-cloud-download"></span>
            <?=\yii::t('app', 'Import teams')?>
        </a>
    </td>
    <?php endif; ?>

    <?php if (\yii::$app->user->can(\common\components\Rbac::OP_TEAM_EXPORT_ALL)): ?>
    <td>
        <div class="btn-group btn-csv" data-phase="1">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?=\yii::t('app', 'Export to CSV')?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?=Url::toRoute(['/team/export-checking-system'])?>"><?=\yii::t('app', 'For checking system')?></a></li>
                <li><a href="<?=Url::toRoute(['/team/export-registration'])?>"><?=\yii::t('app', 'For registration')?></a></li>
            </ul>
        </div>
    </td>
    <?php endif; ?>

    <td>
        <?=\frontend\widgets\filter\Year::widget(array('checked' => $year))?>
    </td>

</tr></table>

<hr />

<?php if ($teamsCount > 0): ?>

    <?= \yii\grid\GridView::widget([
        'id'           => 'js-teams-table',
        'dataProvider' => $teamsProvider,
        'filterModel'  => $teamsSearch,
        'layout'       => "{items}\n{pager}",
        'tableOptions' => [
            'class' => 'table table-hover table-row-link',
        ],
        'rowOptions' => [
            'class' => 'js-team',
        ],
        'columns' => [
            [
                'attribute' => 'teamName',
                'label' => \yii::t('app', 'Team name'),
                'content' => function (Team $team, $key, $index, $column) {
                    return Html::a(
                        Html::encode($team->name),
                        Url::toRoute(['/team/view', 'id' => $team->id]),
                        ['target' => '_blank']
                    );
                },
                'contentOptions' => ['class' => 'col-xs-2'],
            ],
            [
                'attribute' => 'schoolName',
                'label' => \yii::t('app', 'School name'),
                'content' => function (Team $team, $key, $index, $column) {
                    return Html::encode($team->school->fullName);
                },
                'contentOptions' => ['class' => 'col-xs-2'],
            ],
            [
                'attribute' => 'schoolType',
                'label' => \yii::t('app', 'School type'),
                'filter' => Html::activeDropDownList($teamsSearch, 'schoolType', $teamsSearch->filterSchoolTypeOptions(), [
                    'class' => 'form-control',
                ]),
                'content' => function (Team $team, $key, $index, $column) {
                    return School::getConstantLabel($team->school->type);
                },
                'contentOptions' => ['class' => 'col-xs-1'],
            ],
            [
                'attribute' => 'coachName',
                'label' => \yii::t('app', 'Coach name'),
                'content' => function (Team $team, $key, $index, $column) {
                    return Html::a(
                        \frontend\widgets\user\Name::widget(['user' => $team->coach]),
                        Url::toRoute(['/user/view', 'id' => $team->coachId]),
                        ['target' => '_blank']
                    );
                },
                'contentOptions' => ['class' => 'col-xs-1'],
            ],
            [
                'label' => \yii::t('app', 'Members'),
                'content' => function (Team $team, $key, $index, $column) {
                    $items = [];
                    foreach ($team->members as $member) {
                        $items[] = Html::a(
                            \frontend\widgets\user\Name::widget(['user' => $member->user]),
                            Url::toRoute(['/user/view', 'id' => $member->userId]),
                            ['target' => '_blank']
                        );
                    }
                    return implode(', ', $items);
                },
                'contentOptions' => ['class' => 'col-xs-2'],
            ],
            [
                'attribute' => 'state',
                'label' => \yii::t('app', 'State'),
                'filter' => Html::activeDropDownList($teamsSearch, 'state', $teamsSearch->filterStateOptions(), [
                    'class' => 'form-control',
                ]),
                'content' => function (Team $team, $key, $index, $column) {
                    return $team->school->getStateLabel();
                },
                'contentOptions' => ['class' => 'col-xs-1'],
            ],
            [
                'attribute' => 'region',
                'label' => \yii::t('app', 'Region'),
                'filter' => Html::activeDropDownList($teamsSearch, 'region', $teamsSearch->filterRegionOptions(), [
                    'class' => 'form-control',
                ]),
                'content' => function (Team $team, $key, $index, $column) {
                    return $team->school->getRegionLabel();
                },
                'contentOptions' => ['class' => 'col-xs-1'],
            ],
            [
                'attribute' => 'isOutOfCompetition',
                'label' => \yii::t('app', 'Status'),
                'filter' => Html::activeDropDownList($teamsSearch, 'isOutOfCompetition', [
                    ''      => \yii::t('app', 'All'),
                    'no'    => \yii::t('app', 'In competition'),
                    'yes'   => \yii::t('app', 'Out of competition'),
                ], [
                    'class' => 'form-control',
                ]),
                'content' => function (Team $team, $key, $index, $column) {
                    return ($team->isOutOfCompetition) ? \yii::t('app', 'Out of competition') : \yii::t('app', 'In competition');
                },
                'contentOptions' => ['class' => 'col-xs-1'],
            ],
            [
                'attribute' => 'phase',
                'label' => \yii::t('app', 'Stage'),
                'filter' => Html::activeDropDownList($teamsSearch, 'phase', [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                ], [
                    'class' => 'form-control',
                ]),
                'content' => function (Team $team, $key, $index, $column) {
                    return $team->phase;
                },
                'contentOptions' => ['class' => 'col-xs-1'],
            ],
        ],
    ]) ?>

<?php else: ?>

    <div class="alert alert-info">
        <?=\yii::t('app', 'There are no teams.')?>
    </div>

<?php endif; ?>