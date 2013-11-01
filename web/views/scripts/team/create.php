<script type="text/javascript">
    $(document).ready(function() {
        new appTeamCreate();
    });
</script>

<div class="row">
    <div class="col-lg-5 col-lg-offset-1">

        <div class="panel panel-primary panel-school">
            <div class="panel-heading">
                <?=\yii::t('app', 'School info')?>
            </div>

            <div class="panel-body form">

                <div class="form-group">
                    <p class="form-control-static"><b><?=date('Y')?></b>&nbsp;<?=\yii::t('app', 'year')?></p>
                </div>

                <div class="form-group">
<!--                    <label>--><?//=\yii::t('app', 'Full name of university (ukrainian)')?><!--</label>-->
                    <p class="form-control-static"><?=$school->fullNameUk?></p>
                </div>

                <div class="form-group">
<!--                    <label for="shortNameUk">--><?//=\yii::t('app', 'Short name of university (ukrainian)')?><!--</label>-->
                    <input type="text" class="form-control" id="shortNameUk" name="shortNameUk"
                           placeholder="<?=\yii::t('app', 'Short name of university (ukrainian)')?>"
                           value="<?=$school->shortNameUk?>"
                           <?=(!empty($school->shortNameUk)) ? ' disabled="disabled"' : ''?>>
                </div>

                <div class="form-group">
<!--                    <label for="fullNameEn">--><?//=\yii::t('app', 'Full name of university (english)')?><!--</label>-->
                    <input type="text" class="form-control" id="fullNameEn" name="fullNameEn"
                           placeholder="<?=\yii::t('app', 'Full name of university (english)')?>"
                           value="<?=$school->fullNameEn?>"
                           <?=(!empty($school->fullNameEn)) ? ' disabled="disabled"' : ''?>>
                </div>

                <div class="form-group">
<!--                    <label for="shortNameEn">--><?//=\yii::t('app', 'Short name of university (english)')?><!--</label>-->
                    <input type="text" class="form-control" id="shortNameEn"
                           name="shortNameEn" placeholder="<?=\yii::t('app', 'Short name of university (english)')?>"
                           value="<?=$school->shortNameEn?>"
                           <?=(!empty($school->shortNameEn)) ? ' disabled="disabled"' : ''?>>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary btn-lg save-school-info"<?=(!empty($school->shortNameUk) && !empty($school->fullNameEn) && !empty($school->shortNameEn))? ' disabled': ''?>>
                        <?=\yii::t('app', 'Save')?>
                    </button>
                </div>


            </div>
        </div>

    </div>



    <div class="col-lg-5">

        <div class="panel panel-primary panel-team">
            <div class="panel-heading">
                <?=\yii::t('app', 'Team info')?>
            </div>

            <div class="panel-body form">

                <div class="form-group">
                    <label for="teamName"><?=\yii::t('app', 'Name of a team')?></label>
                    <input type="text" class="form-control" id="teamName" name="teamName" placeholder="<?=\yii::t('app', 'Name of your team')?>"/>
                </div>

                <div class="form-group">
                    <label for="teamNamePrefix"><?=\yii::t('app', 'Name of a team with prefix   ')?></label>
                    <input type="text" class="form-control" id="teamNamePrefix" name="teamNamePrefix" placeholder="<?=\yii::t('app', 'Name of your team with prefix')?>" readonly/>
                </div>

            </div>
        </div>

    </div>
</div>