<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<script type="text/javascript">
    $(document).ready(function() {
        new appDocsItem();
    });
</script>

<div class="page-header">
    <h1><?=\yii::t('app', 'Regulation docs')?></h1>
</div>

<?php if (\yii::$app->user->can(\common\components\Rbac::OP_DOCUMENT_CREATE)): ?>
    <a href="<?=Url::toRoute(['/staff/docs/create', 'type' => \common\models\Document::TYPE_REGULATIONS])?>" class="btn btn-success btn-lg">
        <?=\yii::t('app', 'Upload Doc')?>
    </a>
    <hr />
<?php endif; ?>

<?php foreach ($documentList as $document): ?>
    <?=\frontend\widgets\document\Row::widget(array('document' => $document))?>
<?php endforeach; ?>