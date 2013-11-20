<?php
    \yii::app()->getClientScript()->registerCoreScript('plupload');
?>

<script type="text/javascript">
    $(document).ready(function() {
        new appDocsItem();
        new appResults();
    });
</script>


<?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_DOCUMENT_CREATE)): ?>
    <div class="row">
        <div class="col-lg-12" id="upload_container2">
            <button class="btn btn-lg btn-primary" id="pickfiles-modal" data-toggle="modal" data-target="#uploadModal">
                <?=\yii::t('app', 'Upload results')?>
            </button>
        </div>
    </div>
<?php endif; ?>

<div class="page-header">
    <h1><?=\yii::t('app', '1st Phase Results')?></h1>
</div>
<ul>
    <?php foreach($states as $state): ?>
        <li>
            <a href="<?=$this->createUrl('/results/view', array('year' => date('Y'), 'phase' => 1, 'state' => $state))?>">
                <?=\common\models\Geo\State::model()->getAttributeLabel($state, 'name')?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<div class="page-header">
    <h1><?=\yii::t('app', '2nd Phase Results')?></h1>
</div>
<ul>
    <?php foreach($regions as $region): ?>
        <li>
            <a href="<?=$this->createUrl('/results/view', array('year' => date('Y'), 'phase' => 2, 'region' => $region))?>">
                <?=\common\models\Geo\Region::model()->getAttributeLabel($region, 'name')?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<div class="page-header">
    <h1><?=\yii::t('app', '3rd Phase Results')?></h1>
</div>
<ul>
    <li>
        <a href="<?=$this->createUrl('/results/view', array('year' => date('Y'), 'phase' => 3, 'country' => \common\models\School::getCountry()))?>">
            <?=\common\models\School::getCountryLabel()?>
        </a>
    </li>
</ul>

<!-- Upload modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?=\yii::t('app', 'Upload results')?></h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-12" id="upload_container">
                    <div class="form-group">
                        <p class="form-control-static"><b><?=date('Y')?></b>&nbsp;<?=\yii::t('app', 'year')?></p>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-lg2 btn-info" id="pickfiles">
                            <?=\yii::t('app', 'Choose file')?>
                        </button>
                        <span class="document-origin-filename"></span>
                        <div class="help-block"></div>
                    </div>

                    <div class="form-group">
                        <div class="radio">
                            <label class="control-label">
                                <input type="radio" name="phase" id="phase1" value="1"> <?=\yii::t('app', '1st phase')?>
                            </label>
                        </div>
                        <div class="radio">
                            <label class="control-label">
                                <input type="radio" name="phase" id="phase2" value="2"> <?=\yii::t('app', '2nd phase')?>
                            </label>
                        </div>
                        <div class="radio">
                            <label class="control-label">
                                <input type="radio" name="phase" id="phase3" value="3"> <?=\yii::t('app', '3rd phase')?>
                            </label>
                        </div>
                    </div>

                    <button class="btn btn-primary" id="uploadResults" disabled>
                        <?=\yii::t('app', 'Upload')?>
                    </button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->