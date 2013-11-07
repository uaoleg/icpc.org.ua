<script type="text/javascript">
    $(document).ready(function() {
        new appDocsItem();
    });
</script>

<div class="page-header">
    <h1><?=\yii::t('app', '1st Phase Results')?></h1>
</div>

<?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_DOCUMENT_CREATE)): ?>
    <a href="<?=$this->createUrl('/staff/docs/create', array('type' => \common\models\Document::TYPE_RESULTS_PHASE_1))?>" class="btn btn-success btn-lg">
        <?=\yii::t('app', 'Upload Results')?>
    </a>
    <hr />
<?php endif; ?>

<?php if (count($phase1) > 0): ?>
    <?php foreach ($phase1 as $result): ?>
        <?php \web\widgets\document\Row::create(array('document' => $result)); ?>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-info">
        <?=\yii::t('app', 'No results.')?>
    </div>
<?php endif; ?>

<div class="page-header">
    <h1><?=\yii::t('app', '2nd Phase Results')?></h1>
</div>
<?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_DOCUMENT_CREATE)): ?>
    <a href="<?=$this->createUrl('/staff/docs/create', array('type' => \common\models\Document::TYPE_RESULTS_PHASE_2))?>" class="btn btn-success btn-lg">
        <?=\yii::t('app', 'Upload Results')?>
    </a>
    <hr />
<?php endif; ?>
<?php if (count($phase2) > 0): ?>
    <?php foreach ($phase2 as $result): ?>
        <?php \web\widgets\document\Row::create(array('document' => $result)); ?>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-info">
        <?=\yii::t('app', 'No results.')?>
    </div>
<?php endif; ?>

<div class="page-header">
    <h1><?=\yii::t('app', '3d Phase Results')?></h1>
</div>
<?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_DOCUMENT_CREATE)): ?>
    <a href="<?=$this->createUrl('/staff/docs/create', array('type' => \common\models\Document::TYPE_RESULTS_PHASE_3))?>" class="btn btn-success btn-lg">
        <?=\yii::t('app', 'Upload Results')?>
    </a>
    <hr />
<?php endif; ?>
<?php if (count($phase3) > 0): ?>
    <?php foreach ($phase3 as $result): ?>
        <?php \web\widgets\document\Row::create(array('document' => $result)); ?>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-info">
        <?=\yii::t('app', 'No results.')?>
    </div>
<?php endif; ?>