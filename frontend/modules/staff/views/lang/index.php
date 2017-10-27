<?php

/* @var $this      \yii\web\View */
/* @var $provider  \yii\data\ActiveDataProvider */
/* @var $search    \frontend\modules\staff\search\LangSearch */

use \yii\bootstrap\ActiveForm;
use \yii\helpers\Html;
use \yii\helpers\Url;

$this->title = \yii::t('app', 'Languages');

?>

<div class="staff-translate-form-container clearfix">
    <?php ActiveForm::begin(['action' => Url::toRoute(['parse'])]) ?>
    <button type="submit" class="btn btn-default pull-left parse" rel="tooltip" title="<?=\yii::t('app', 'Update translation messages')?>">
        <?=\yii::t('app', 'Update')?>
    </button>
    <?php ActiveForm::end() ?>
</div>

<br />

<?= \yii\grid\GridView::widget([
    'id'           => 'js-translations-table',
    'dataProvider' => $provider,
    'filterModel'  => $search,
    'layout'       => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-hover table-row-link',
    ],
    'rowOptions' => [
        'class' => 'js-translation',
    ],
    'columns' => [
        [
            'attribute' => 'language',
            'contentOptions' => ['class' => 'col-xs-1'],
        ],
        [
            'attribute' => 'message',
            'contentOptions' => ['class' => 'col-xs-5'],
        ],
        [
            'attribute' => 'translation',
            'contentOptions' => ['class' => 'col-xs-6'],
        ],
    ],
]) ?>
