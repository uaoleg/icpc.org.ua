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
    <label class="col-lg-3 control-label" for="ACMNumber"><?=\yii::t('app', 'ACM Number', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="ACMNumber" name="ACMNumber" type="text"
               value="<?=\CHtml::encode($info->ACMNumber)?>"
               placeholder="<?=\yii::t('app', 'ACM Number', null, null, $lang)?>" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="instName"><?=\yii::t('app', 'Institution name', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="instName" name="instName" type="text"
               value="<?=\CHtml::encode($info->instName)?>"
               placeholder="<?=\yii::t('app', 'Institution name', null, null, $lang)?>" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="instNameShort"><?=\yii::t('app', 'Institution short name', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="instNameShort" name="instNameShort" type="text"
               value="<?=\CHtml::encode($info->instNameShort)?>"
               placeholder="<?=\yii::t('app', 'Institution short name', null, null, $lang)?>" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="instDivision"><?=\yii::t('app', 'Divison (I or II)', null, null, $lang)?></label>
    <div class="col-lg-9">
        <div class="radio">
            <label>
                <input type="radio" name="instDivision" value="I"<?=($info->instDivision === 'I') ? ' checked' : ''?>>
                I
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="instDivision" value="II"<?=($info->instDivision === 'II') ? ' checked' : ''?>>
                II
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="instPostEmailAddresses"><?=\yii::t('app', 'Official post and email addresses', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="instPostEmailAddresses" name="instPostEmailAddresses" type="text"
               value="<?=\CHtml::encode($info->instPostEmailAddresses)?>"
               placeholder="<?=\yii::t('app', 'Official post and email addresses', null, null, $lang)?>" />
    </div>
</div>