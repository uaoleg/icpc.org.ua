<?php

/* @var $this      \yii\web\View */
/* @var $provider  \yii\data\ActiveDataProvider */
/* @var $search    \frontend\modules\staff\search\CoachSearch */

use \common\models\User;
use \yii\helpers\Html;
use \yii\helpers\Json;
use \yii\helpers\Url;

?>

<h3><?=\yii::t('app', 'List of Coordinators')?></h3>

<?php if (\yii::$app->user->can(User::ROLE_COORDINATOR_UKRAINE, array('user' => \yii::$app->user->identity))): ?>
<div class="btn-group">
    <button type="button" class="btn btn-danger" id="deactivateAllCoordinatorsModal-modal" data-toggle="modal" data-target="#deactivateAllCoordinatorsModal">
        <?=\yii::t('app', 'Deactivate all coordinators')?>
    </button>
</div>
<?php endif; ?>

<br><br>

<table id="staff__coordinators_list" style="width: 100%;"></table>

<?php if (\yii::$app->user->can(User::ROLE_COORDINATOR_UKRAINE, array('user' => \yii::$app->user->identity))): ?>
<div class="modal" id="deactivateAllCoordinatorsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?=\yii::t('app', 'Deactivate all coordinators')?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" id="uploadContainer">
                        <div class="form-group">
                            <p class="form-control-static">
                              <?=\yii::t('app', 'Are you really want to deactivate all coordinators?')?>
                            </p>
                        </div>

                        <div class="form-group">
                            <a href="<?=Url::toRoute(['/staff/coordinators/deactivate-all'])?>" class="btn btn-danger confirmation">
                                <?=\yii::t('app', 'Deactivate all coordinators')?>
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
    'id'           => 'js-coordinators-table',
    'dataProvider' => $provider,
    'filterModel'  => $search,
    'layout'       => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-hover table-row-link',
    ],
    'rowOptions' => [
        'class' => 'js-coordinator',
    ],
    'columns' => [
        [
            'attribute' => 'name',
            'label' => \yii::t('app', 'Name'),
            'content' => function (User $coordiantor, $key, $index, $column) {
                return Html::a(
                    \frontend\widgets\user\Name::widget(['user' => $coordiantor]),
                    Url::toRoute(['/user/view', 'id' => $coordiantor->id]),
                    ['target' => '_blank']
                );
            },
            'contentOptions' => ['class' => 'col-xs-2'],
        ],
        [
            'attribute' => 'email',
            'label' => \yii::t('app', 'Email'),
            'content' => function (User $coordiantor, $key, $index, $column) {
                return Html::encode($coordiantor->email);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'school',
            'label' => \yii::t('app', 'School'),
            'filter' => Html::activeDropDownList($search, 'state', $search->filterStateOptions(), [
                'class' => 'form-control',
            ]),
            'content' => function (User $coordiantor, $key, $index, $column) {
                return Html::encode($coordiantor->school->fullNameUk);
            },
            'contentOptions' => ['class' => 'col-xs-2'],
        ],
        [
            'attribute' => 'timeCreated',
            'label' => \yii::t('app', 'Registration date'),
            'content' => function (User $coordiantor, $key, $index, $column) {
                return \yii::$app->formatter->asDate($coordiantor->timeCreated);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'status',
            'label' => \yii::t('app', 'Status'),
            'filter' => Html::activeDropDownList($search, 'status', $search->filterStatusOptions(), [
                'class' => 'form-control',
            ]),
            'content' => function (User $coordiantor, $key, $index, $column) {
                return $this->render('index/action', [
                    'coordiantor' => $coordiantor,
                ]);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
    ],
]) ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffCoordinatorsIndex();
    });
</script>
