<div class="form-group">
    <label class="col-lg-3 control-label" for="phoneHome"><?=\yii::t('app', 'Home phone', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="phoneHome" name="phoneHome" type="text"
               value="<?=\CHtml::encode($info->phoneHome)?>"
               placeholder="<?=\yii::t('app', 'Home phone number', null, null, $lang)?>" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="phoneMobile"><?=\yii::t('app', 'Mobile phone', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="phoneMobile" name="phoneMobile" type="text"
               value="<?=\CHtml::encode($info->phoneMobile)?>"
               placeholder="<?=\yii::t('app', 'Mobile phone number', null, null, $lang)?>" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="skype"><?=\yii::t('app', 'Skype', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="skype" name="skype" type="text"
               value="<?=\CHtml::encode($info->skype)?>"
               placeholder="<?=\yii::t('app', 'Skype', null, null, $lang)?>" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="acmNumber"><?=\yii::t('app', 'ACM Number', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="acmNumber" name="acmNumber" type="text"
               value="<?=\CHtml::encode($info->acmNumber)?>"
               placeholder="<?=\yii::t('app', 'ACM Number', null, null, $lang)?>" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="schoolName"><?=\yii::t('app', 'School name', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="schoolName" name="schoolName" type="text"
               value="<?=\CHtml::encode($info->schoolName)?>"
               placeholder="<?=\yii::t('app', 'School name', null, null, $lang)?>" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="schoolNameShort"><?=\yii::t('app', 'School short name', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="schoolNameShort" name="schoolNameShort" type="text"
               value="<?=\CHtml::encode($info->schoolNameShort)?>"
               placeholder="<?=\yii::t('app', 'School short name', null, null, $lang)?>" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="schoolDivision"><?=\yii::t('app', 'Divison (I or II)', null, null, $lang)?></label>
    <div class="col-lg-9">
        <div class="radio">
            <label>
                <input type="radio" name="schoolDivision" value="I"<?=($info->schoolDivision === 'I') ? ' checked' : ''?>>
                I
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="schoolDivision" value="II"<?=($info->schoolDivision === 'II') ? ' checked' : ''?>>
                II
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="schoolPostEmailAddresses"><?=\yii::t('app', 'Official post and email addresses', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="schoolPostEmailAddresses" name="schoolPostEmailAddresses" type="text"
               value="<?=\CHtml::encode($info->schoolPostEmailAddresses)?>"
               placeholder="<?=\yii::t('app', 'Official post and email addresses', null, null, $lang)?>" />
    </div>
</div>