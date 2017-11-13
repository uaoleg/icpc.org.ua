<?php

/* @var $this               \yii\web\View */
/* @var $resultsProvider    \yii\data\ActiveDataProvider */
/* @var $resultsSearch      \frontend\search\ResultSearch */
/* @var $geo                string */
/* @var $header             string */
/* @var $year               int */
/* @var $phase              int */

use \common\models\Result;
use \common\models\School;
use \yii\helpers\Html;
use \yii\helpers\Json;
use \yii\helpers\Url;

$this->registerCssFile('@web/lib/jquery/jquery.jqGrid-4.5.2/css/ui.jqgrid.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/lib/jquery/jquery.jqGrid-4.5.2/js/jquery.jqGrid.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/lib/jquery/jquery.jqGrid-4.5.2/js/i18n/grid.locale-en.js', ['position' => \yii\web\View::POS_HEAD]);

?>

<div class="page-header">
    <h1><?=$header?> <small><?=$year?>, <?=\yii::t('app', 'stage')?> <?=$phase?></small></h1>
    <?php if (\yii::$app->user->can(\common\models\User::ROLE_COORDINATOR_STATE)): ?>
        <div class="dropdown">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?=\yii::t('app', 'Reports')?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a target="_blank" href="<?=Url::toRoute(['/staff/reports/participants', 'phase' => $phase, 'year' => $year, 'geo' => $geo])?>">
                        <?=\yii::t('app', 'Participants')?>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="<?=Url::toRoute(['/staff/reports/winners', 'phase' => $phase, 'year' => $year, 'geo' => $geo])?>">
                        <?=\yii::t('app', 'Winners')?>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>

<?= \yii\grid\GridView::widget([
    'id'           => 'js-results-table',
    'dataProvider' => $resultsProvider,
    'filterModel'  => $resultsSearch,
    'layout'       => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-hover table-row-link',
    ],
    'rowOptions' => [
        'class' => 'js-result',
    ],
    'columns' => [
        [
            'attribute' => 'place',
            'label' => \yii::t('app', 'Place'),
            'content' => function (Result $result, $key, $index, $column) {
                return $this->render('view/cell-place', [
                    'result' => $result,
                ]);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'teamName',
            'label' => \yii::t('app', 'Team name'),
            'content' => function (Result $result, $key, $index, $column) {
                return $this->render('view/cell-team-name', [
                    'result' => $result,
                ]);
            },
            'contentOptions' => ['class' => 'col-xs-4'],
        ],
        [
            'attribute' => 'coachName',
            'label' => \yii::t('app', 'Coach name'),
            'content' => function (Result $result, $key, $index, $column) {
                if ($result->team) {
                    return Html::a(
                        \frontend\widgets\user\Name::widget(['user' => $result->team->coach]),
                        Url::toRoute(['/user/view', 'id' => $result->team->coachId]),
                        ['target' => '_blank']
                    );
                } else {
                    return null;
                }
            },
            'contentOptions' => ['class' => 'col-xs-4'],
        ],
        [
            'attribute' => 'schoolName',
            'label' => \yii::t('app', 'School name'),
            'content' => function (Result $result, $key, $index, $column) {
                if ($result->team) {
                    School::$useLanguage = \yii::$app->user->languageCore;
                    return Html::encode($result->team->school->fullName);
                } else {
                    return null;
                }
            },
            'contentOptions' => ['class' => 'col-xs-4'],
        ],
        [
            'attribute' => 'total',
            'label' => \yii::t('app', 'Total'),
            'contentOptions' => ['class' => 'col-xs-1 text-center'],
        ],
        [
            'attribute' => 'penalty',
            'label' => \yii::t('app', 'Penalty'),
            'contentOptions' => ['class' => 'col-xs-1 text-center'],
        ],
        [
            'label' => \yii::t('app', 'Tasks'),
            'content' => function (Result $result, $key, $index, $column) {
                return $this->render('view/cell-tasks', [
                    'result' => $result,
                ]);
            },
            'contentOptions' => ['class' => 'col-xs-1 text-center'],
        ],
    ],
]) ?>

<script>
$(function () {
    appResultsView();
})
</script>
