<?php \yii::app()->clientScript->registerCoreScript('bootstrap.datepicker'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appUserAdditionalGeneral();
    });
</script>

<div class="form-group">
    <label class="col-lg-3 control-label" for="phoneHome"><?=\yii::t('app', 'Home phone', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="phoneHome" name="phoneHome" type="text"
               value="<?=\CHtml::encode($info->phoneHome)?>"
               placeholder="<?=\yii::t('app', 'Home phone number', null, null, $lang)?>" data-baylor-phoneHome="" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="phoneMobile"><?=\yii::t('app', 'Mobile phone', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="phoneMobile" name="phoneMobile" type="text"
               value="<?=\CHtml::encode($info->phoneMobile)?>"
               placeholder="<?=\yii::t('app', 'Mobile phone number', null, null, $lang)?>" data-baylor-phoneMobile="" />
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="dateOfBirth"><?=\yii::t('app', 'Date of birth', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="dateOfBirth" name="dateOfBirth" type="text"
               value="<?=(is_int($info->dateOfBirth)) ? date('Y-m-d', $info->dateOfBirth) : ''?>"
               placeholder="<?=\yii::t('app', 'Date of birth', null, null, $lang)?>"
               data-baylor-birthday="" />
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
    <label class="col-lg-3 control-label"><?=\yii::t('app', 'T-shirt size', null, null, $lang)?></label>
    <div class="col-lg-9">
        <div class="btn-group" data-toggle="buttons">
            <?php foreach($sizes as $size): ?>

                <label class="btn btn-default <?=($info->tShirtSize === $size) ? 'active' : ''?>">
                    <input type="radio" name="tShirtSize" value="<?=$size?>" <?=($info->tShirtSize === $size) ? 'checked' : ''?>><?=$size?>
                </label>

            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label" for="acmNumber"><?=\yii::t('app', 'ACM Number', null, null, $lang)?></label>
    <div class="col-lg-9">
        <input class="form-control" id="acmNumber" name="acmNumber" type="text"
               value="<?=\CHtml::encode($info->acmNumber)?>"
               placeholder="<?=\yii::t('app', 'ACM Number', null, null, $lang)?>"
               data-baylor-acmId="" />
    </div>
</div>