<script type="text/javascript">
    $(document).ready(function() {
        new appUserAdditionalStudent({
            lang: '<?=$lang?>'
        });
    });
</script>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <ul class="nav nav-tabs nav-justified">
            <li><a href="<?=$this->createUrl('/user/me')?>"><?=\yii::t('app', 'General info')?></a></li>
            <li class="<?=($lang==='uk') ? 'active' : ''?>"><a href="<?=$this->createUrl('/user/additional/lang/uk')?>"><?=\yii::t('app', 'Additional info (ukrainian)')?></a></li>
            <li class="<?=($lang==='en') ? 'active' : ''?>"><a href="<?=$this->createUrl('/user/additional/lang/en')?>"><?=\yii::t('app', 'Additional info (english)')?></a></li>
        </ul>

        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="form-horizontal">
                    <?php $this->renderPartial('partial/additional', array(
                        'lang' => $lang,
                        'info' => $info,
                    )); ?>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="studyField"><?=\yii::t('app', 'Field of study', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="studyField" name="studyField" type="text"
                                   value="<?=\CHtml::encode($info->studyField)?>"
                                   placeholder="<?=\yii::t('app', 'Field of study', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="speciality"><?=\yii::t('app', 'Speciality', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="speciality" name="speciality" type="text"
                                   value="<?=\CHtml::encode($info->speciality)?>"
                                   placeholder="<?=\yii::t('app', 'Speciality', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="faculty"><?=\yii::t('app', 'Faculty', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="faculty" name="faculty" type="text"
                                   value="<?=\CHtml::encode($info->faculty)?>"
                                   placeholder="<?=\yii::t('app', 'Faculty', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="group"><?=\yii::t('app', 'Group', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="group" name="group" type="text"
                                   value="<?=\CHtml::encode($info->group)?>"
                                   placeholder="<?=\yii::t('app', 'Group', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="schoolAdmissionYear"><?=\yii::t('app', 'Year of admission to school', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="schoolAdmissionYear" name="schoolAdmissionYear" type="text"
                                   value="<?=\CHtml::encode($info->schoolAdmissionYear)?>"
                                   placeholder="<?=\yii::t('app', 'Year of admission to school', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="dateOfBirth"><?=\yii::t('app', 'Date of birth', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="dateOfBirth" name="dateOfBirth" type="text"
                                   value="<?=\CHtml::encode($info->dateOfBirth)?>"
                                   placeholder="<?=\yii::t('app', 'Date of birth', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="document"><?=\yii::t('app', 'Student document serial number', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="document" name="document" type="text"
                                   value="<?=\CHtml::encode($info->document)?>"
                                   placeholder="<?=\yii::t('app', 'Student document serial number', null, null, $lang)?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button class="btn btn-lg btn-primary btn-save"><?=\yii::t('app', 'Save')?></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>