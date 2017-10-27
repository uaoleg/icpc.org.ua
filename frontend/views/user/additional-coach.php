<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<script type="text/javascript">
    $(document).ready(function() {
        new appUserAdditionalCoach({
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
                        <label class="col-lg-3 control-label" for="position"><?=\yii::t('app', 'Position', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="position" name="position" type="text"
                                   value="<?=Html::encode($info->position)?>"
                                   placeholder="<?=\yii::t('app', 'Position', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="officeAddress"><?=\yii::t('app', 'Office address', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="officeAddress" name="officeAddress" type="text"
                                   value="<?=Html::encode($info->officeAddress)?>"
                                   placeholder="<?=\yii::t('app', 'Office address', null, null, $lang)?>"
                                   data-baylor-officeAddress="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="phoneWork"><?=\yii::t('app', 'Work phone number', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="phoneWork" name="phoneWork" type="text"
                                   value="<?=Html::encode($info->phoneWork)?>"
                                   placeholder="<?=\yii::t('app', 'Work phone number', null, null, $lang)?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="fax"><?=\yii::t('app', 'Fax number', null, null, $lang)?></label>
                        <div class="col-lg-9">
                            <input class="form-control" id="fax" name="fax" type="text"
                                   value="<?=Html::encode($info->fax)?>"
                                   placeholder="<?=\yii::t('app', 'Fax number', null, null, $lang)?>" />
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