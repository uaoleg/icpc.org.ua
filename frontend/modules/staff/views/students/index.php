<?php

/* @var $this      \yii\web\View */
/* @var $provider  \yii\data\ActiveDataProvider */
/* @var $search    \frontend\modules\staff\search\StudentSearch */

use \common\models\User;
use \yii\helpers\Html;
use \yii\helpers\Json;
use \yii\helpers\Url;

?>

<h3>
    <?=\yii::t('app', 'List of Students')?>
    <?php if (\yii::$app->user->can(\common\components\Rbac::OP_USER_EXPORT)): ?>
        <div class="btn-group btn-csv" data-phase="1">
            <a class="btn btn-default" role="button" href="<?=Url::toRoute(['/staff/students/export'])?>"> <?=\yii::t('app', 'Export to CSV')?></a>
        </div>
    <?php endif; ?>
</h3>

<?= \yii\grid\GridView::widget([
    'id'           => 'js-students-table',
    'dataProvider' => $provider,
    'filterModel'  => $search,
    'layout'       => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-hover table-row-link',
    ],
    'rowOptions' => [
        'class' => 'js-student',
    ],
    'columns' => [
        [
            'attribute' => 'name',
            'label' => \yii::t('app', 'Name'),
            'content' => function (User $student, $key, $index, $column) {
                return Html::a(
                    \frontend\widgets\user\Name::widget(['user' => $student]),
                    Url::toRoute(['/user/view', 'id' => $student->id]),
                    ['target' => '_blank']
                );
            },
            'contentOptions' => ['class' => 'col-xs-2'],
        ],
        [
            'attribute' => 'school',
            'label' => \yii::t('app', 'School'),
            'content' => function (User $student, $key, $index, $column) {
                return Html::encode($student->school->fullNameUk);
            },
            'contentOptions' => ['class' => 'col-xs-2'],
        ],
        [
            'attribute' => 'speciality',
            'label' => \yii::t('app', 'Speciality'),
            'content' => function (User $student, $key, $index, $column) {
                return Html::encode($student->info->speciality);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'group',
            'label' => \yii::t('app', 'Group'),
            'content' => function (User $student, $key, $index, $column) {
                return Html::encode($student->info->group);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'email',
            'label' => \yii::t('app', 'Email'),
            'content' => function (User $student, $key, $index, $column) {
                return Html::encode($student->email);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'phone',
            'label' => \yii::t('app', 'Phone'),
            'content' => function (User $student, $key, $index, $column) {
                return implode('<br>', array_filter([
                    $student->info->phoneMobile,
                    $student->info->phoneHome,
                ]));
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'course',
            'label' => \yii::t('app', 'Course'),
            'content' => function (User $student, $key, $index, $column) {
                return Html::encode($student->info->course);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'dateOfBirth',
            'label' => \yii::t('app', 'Date of birth'),
            'content' => function (User $student, $key, $index, $column) {
                return $student->info->dateOfBirth;
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'timeCreated',
            'label' => \yii::t('app', 'Registration date'),
            'content' => function (User $student, $key, $index, $column) {
                return \yii::$app->formatter->asDate($student->timeCreated);
            },
            'contentOptions' => ['class' => 'col-xs-1', 'style' => 'min-width: 120px;'],
        ],
        [
            'attribute' => 'status',
            'label' => \yii::t('app', 'Status'),
            'content' => function (User $student, $key, $index, $column) {
                return $this->render('index/action', [
                    'student' => $student,
                ]);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
    ],
]) ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffStudentsIndex();
    });
</script>
