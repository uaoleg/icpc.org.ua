<?php

/* @var $this      \yii\web\View */
/* @var $provider  \yii\data\ActiveDataProvider */
/* @var $search    \frontend\modules\staff\search\CoachSearch */

use \common\models\User;
use \yii\helpers\Html;
use \yii\helpers\Json;
use \yii\helpers\Url;

?>

<h3><?=\yii::t('app', 'List of Coaches')?></h3>

<?php if (\yii::$app->user->can(User::ROLE_COORDINATOR_UKRAINE, array('user' => \yii::$app->user->identity))): ?>
<div class="btn-group">
    <button type="button" class="btn btn-danger" id="deactivateAllCoachesModal-modal" data-toggle="modal" data-target="#deactivateAllCoachesModal">
        <?=\yii::t('app', 'Deactivate all coaches')?>
    </button>
</div>
<?php endif; ?>

<br><br>

<table id="staff__coaches_list" style="width: 100%;"></table>

<?php if (\yii::$app->user->can(User::ROLE_COORDINATOR_UKRAINE, array('user' => \yii::$app->user->identity))): ?>
<div class="modal" id="deactivateAllCoachesModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?=\yii::t('app', 'Deactivate all coaches')?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" id="uploadContainer">
                        <div class="form-group">
                            <p class="form-control-static">
                              <?=\yii::t('app', 'Are you really want to deactivate all coaches?')?>
                            </p>
                        </div>
                        <div class="form-group">
                            <a href="<?=Url::toRoute(['/staff/coaches/deactivate-all'])?>" class="btn btn-danger confirmation">
                                <?=\yii::t('app', 'Deactivate all coaches')?>
                            </a>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?=\yii::t('app', 'Cancel')?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= \yii\grid\GridView::widget([
    'id'           => 'js-coachs-table',
    'dataProvider' => $provider,
    'filterModel'  => $search,
    'layout'       => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-hover table-row-link',
    ],
    'rowOptions' => [
        'class' => 'js-coach',
    ],
    'columns' => [
        [
            'attribute' => 'name',
            'label' => \yii::t('app', 'Name'),
            'content' => function (User $coach, $key, $index, $column) {
                return Html::a(
                    \frontend\widgets\user\Name::widget(['user' => $coach]),
                    Url::toRoute(['/user/view', 'id' => $coach->id]),
                    ['target' => '_blank']
                );
            },
            'contentOptions' => ['class' => 'col-xs-2'],
        ],
        [
            'attribute' => 'email',
            'label' => \yii::t('app', 'Email'),
            'content' => function (User $coach, $key, $index, $column) {
                return Html::encode($coach->email);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'school',
            'label' => \yii::t('app', 'School'),
            'filter' => Html::activeDropDownList($search, 'state', $search->filterStateOptions(), [
                'class' => 'form-control',
            ]),
            'content' => function (User $coach, $key, $index, $column) {
                return Html::encode($coach->school->fullNameUk);
            },
            'contentOptions' => ['class' => 'col-xs-2'],
        ],
        [
            'attribute' => 'phone',
            'label' => \yii::t('app', 'Phone'),
            'content' => function (User $coach, $key, $index, $column) {
                return implode('<br>', array_filter([
                    $coach->info->phoneMobile,
                    $coach->info->phoneHome,
                ]));
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'timeCreated',
            'label' => \yii::t('app', 'Registration date'),
            'content' => function (User $coach, $key, $index, $column) {
                return \yii::$app->formatter->asDate($coach->timeCreated);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'status',
            'label' => \yii::t('app', 'Status'),
            'content' => function (User $coach, $key, $index, $column) {
                return $this->render('index/action', [
                    'coach' => $coach,
                ]);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
    ],
]) ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffCoachesIndex();
    });
</script>
