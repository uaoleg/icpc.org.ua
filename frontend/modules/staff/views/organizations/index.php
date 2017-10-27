<?php

/* @var $this      \yii\web\View */
/* @var $provider  \yii\data\ActiveDataProvider */
/* @var $search    \frontend\modules\staff\search\OrganizationSearch */

use \common\models\School;
use \yii\helpers\Html;
use \yii\helpers\Url;

$this->title = \yii::t('app', 'Organizations');

?>

<?= \yii\grid\GridView::widget([
    'id'           => 'js-organizations-table',
    'dataProvider' => $provider,
    'filterModel'  => $search,
    'layout'       => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-hover table-row-link',
    ],
    'rowOptions' => [
        'class' => 'js-organization',
    ],
    'columns' => [
        [
            'attribute' => 'fullNameUk',
            'contentOptions' => ['class' => 'col-xs-2'],
        ],
        [
            'attribute' => 'shortNameUk',
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'fullNameEn',
            'contentOptions' => ['class' => 'col-xs-2'],
        ],
        [
            'attribute' => 'shortNameEn',
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'type',
            'filter' => Html::activeDropDownList($search, 'type', $search->filterTypeOptions(), [
                'class' => 'form-control',
            ]),
            'content' => function (School $school, $key, $index, $column) {
                return $school->getConstantLabel($school->type);
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'state',
            'filter' => Html::activeDropDownList($search, 'state', $search->filterStateOptions(), [
                'class' => 'form-control',
            ]),
            'content' => function (School $school, $key, $index, $column) {
                return $school->getStateLabel();
            },
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
    ],
]) ?>

<script type="text/javascript">
    $(document).ready(function(){
        new appStaffLangIndex();
    });
</script>
