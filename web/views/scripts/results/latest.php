<?php
    use \common\models\User;
    \yii::app()->getClientScript()->registerCoreScript('plupload');
?>

<script type="text/javascript">
    $(document).ready(function() {
        new appResultsLatest();
    });
</script>

<div class="pull-right" style="margin-left: 20px;">
    <?php \web\widgets\filter\Year::create(array('checked' => $year)); ?>
</div>

<?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_RESULT_CREATE)): ?>
    <button type="button" class="btn btn-lg btn-primary" id="pickfiles-modal" data-toggle="modal" data-target="#uploadModal">
        <?=\yii::t('app', 'Upload results')?>
    </button>
<?php endif; ?>

<div class="page-header">
    <h1><?=\yii::t('app', '1st Stage Results')?></h1>
</div>
<?php if (count($states) > 0): ?>
<ul>
    <?php foreach($states as $state => $label): ?>
        <li>
            <a href="<?=$this->createUrl('/results/view', array('year' => $year, 'phase' => 1, 'state' => $state))?>">
                <?=$label?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<?php else: ?>
<div class="alert alert-info">
    <?=\yii::t('app', 'There are no results at the moment')?>
</div>
<?php endif; ?>

<div class="page-header">
    <h1><?=\yii::t('app', '2nd Stage Results')?></h1>
</div>
<?php if (count($regions) > 0): ?>
<ul>
    <?php foreach($regions as $region => $label): ?>
        <li>
            <a href="<?=$this->createUrl('/results/view', array('year' => $year, 'phase' => 2, 'region' => $region))?>">
                <?=$label?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<?php else: ?>
<div class="alert alert-info">
    <?=\yii::t('app', 'There are no results at the moment')?>
</div>
<?php endif; ?>

<div class="page-header">
    <h1><?=\yii::t('app', '3rd Stage Results')?></h1>
</div>
<?php if ($hasUkraineResults): ?>
<ul>
    <li>
        <a href="<?=$this->createUrl('/results/view', array('year' => $year,'phase' => 3, 'country' => \common\models\School::getCountry()))?>">
            <?=\common\models\School::getCountryLabel()?>
        </a>
    </li>
</ul>
<?php else: ?>
<div class="alert alert-info">
    <?=\yii::t('app', 'There are no results at the moment')?>
</div>
<?php endif; ?>

<?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_RESULT_CREATE)): ?>
<div class="modal" id="uploadModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?=\yii::t('app', 'Upload results')?></h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" id="uploadContainer">
                    <div class="form-group">
                        <p class="form-control-static"><b><?=date('Y')?></b>&nbsp;<?=\yii::t('app', 'year')?></p>
                    </div>

                    <?php if (!\yii::app()->user->getInstance()->school->getIsNewRecord()): ?>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="uploadPickfiles">
                                <?=\yii::t('app', 'Choose file')?>
                            </button>
                            <span class="document-origin-filename"></span>
                            <div class="help-block"></div>
                        </div>

                        <div class="form-group">
                            <?php \web\widgets\user\GeoFilter::create(); ?>
                        </div>

                        <button type="submit" class="btn btn-primary" id="uploadResults" disabled>
                            <?=\yii::t('app', 'Upload')?>
                        </button>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            <?=\yii::t('app', 'To upload results you have to specify your school at your {a}profile page</a>',
                            array('{a}' => '<a href="' . $this->createUrl('/user/me') . '">'))?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
