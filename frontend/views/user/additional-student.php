<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<script type="text/javascript">
    $(document).ready(function() {
        new appUserAdditionalStudent({
            lang: '<?=$lang?>'
        });
    });
</script>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">

        <?= $this->render('partial/additional-tabs'); ?>

        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="form-horizontal">
                    <?= $this->render('partial/additional', array(
                        'lang'  => $lang,
                        'info'  => $info,
                        'sizes' => $sizes
                    )); ?>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="studyField"><?=\yii::t('app', 'Field of study', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="studyField" name="studyField" type="text"
                                   value="<?=Html::encode($info->studyField)?>"
                                   placeholder="<?=\yii::t('app', 'Field of study', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="speciality"><?=\yii::t('app', 'Speciality', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="speciality" name="speciality" type="text"
                                   value="<?=Html::encode($info->speciality)?>"
                                   placeholder="<?=\yii::t('app', 'Speciality', null, null, $lang)?>"
                                   data-baylor-speciality="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="faculty"><?=\yii::t('app', 'Faculty', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="faculty" name="faculty" type="text"
                                   value="<?=Html::encode($info->faculty)?>"
                                   placeholder="<?=\yii::t('app', 'Faculty', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="group"><?=\yii::t('app', 'Group', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="group" name="group" type="text"
                                   value="<?=Html::encode($info->group)?>"
                                   placeholder="<?=\yii::t('app', 'Group', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="schoolAdmissionYear"><?=\yii::t('app', 'Year of admission to school', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="schoolAdmissionYear" name="schoolAdmissionYear" type="text"
                                   value="<?=Html::encode($info->schoolAdmissionYear)?>"
                                   placeholder="<?=\yii::t('app', 'Year of admission to school', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="course"><?=\yii::t('app', 'Course', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="course" name="course" type="text"
                                   value="<?=Html::encode($info->course)?>"
                                   placeholder="<?=\yii::t('app', 'Course', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="document"><?=\yii::t('app', 'Student document serial number', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="document" name="document" type="text"
                                   value="<?=Html::encode($info->document)?>"
                                   placeholder="<?=\yii::t('app', 'Student document serial number', null, null, $lang)?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-lg btn-primary js-save"><?=\yii::t('app', 'Save')?></button>
                            <?=\frontend\widgets\user\Baylor::widget()?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>