<script type="text/javascript">
    $(document).ready(function() {
        new appStaffTeamSchoolComplete();
    });
</script>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <div class="panel panel-primary panel-school">
            <div class="panel-heading">
                <?=\yii::t('app', 'School Info')?>
            </div>

            <div class="panel-body form">

                <div class="form-group">
                    <p class="form-control-static"><?=\CHtml::encode($school->fullNameUk)?></p>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="shortNameUk"
                           placeholder="<?=\yii::t('app', 'Short name of university (ukrainian)')?>"
                           value="<?=\CHtml::encode($school->shortNameUk)?>"
                        <?=(!empty($school->shortNameUk)) ? ' disabled' : ''?>>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="fullNameEn"
                           placeholder="<?=\yii::t('app', 'Full name of university (english)')?>"
                           value="<?=\CHtml::encode($school->fullNameEn)?>"
                        <?=(!empty($school->fullNameEn)) ? ' disabled' : ''?>>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="shortNameEn"
                           placeholder="<?=\yii::t('app', 'Short name of university (english)')?>"
                           value="<?=\CHtml::encode($school->shortNameEn)?>"
                        <?=(!empty($school->shortNameEn)) ? ' disabled' : ''?>>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-save">
                        <?=\yii::t('app', 'Save')?>
                    </button>
                </div>

            </div>
        </div>

    </div>

</div>