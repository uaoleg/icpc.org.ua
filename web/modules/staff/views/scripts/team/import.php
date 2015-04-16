<script type="text/javascript">
    $(document).ready(function() {
        new appStaffTeamImport({
        });
    });
</script>

<div class="row">

    <div id="formerrors" class="col-lg-6 col-lg-offset-3"></div>

    <div class="col-lg-6 col-lg-offset-3">

        <div class="panel panel-primary panel-school">
            <div class="panel-heading">
                <?=\yii::t('app', 'Import your teams from icpc.baylor.edu')?>
            </div>

            <div class="panel-body form">

                <p>
                    <?= \yii::t('app', 'We promise we will not save any of the data!') ?>
                </p>

                <div class="form-group auth">
                    <label for="name"><?=\yii::t('app', 'Email')?></label>
                    <input type="email" class="form-control" id="email" name="email"
                           value=""
                           placeholder="<?=\yii::t('app', 'Email')?>">
                </div>

                <div class="form-group auth">
                    <label for="name"><?=\yii::t('app', 'Password')?></label>
                    <input type="password" class="form-control" id="password" name="password"
                           value=""
                           placeholder="<?=\yii::t('app', 'Password')?>">
                </div>

                <div class="form-group teams">
                    <label for="name"><?=\yii::t('app', 'Teams')?></label>
                    <select name="team" class="form-control">
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-load">
                        <?=\yii::t('app', 'Import teams')?>
                    </button>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-save">
                        <?=\yii::t('app', 'Import')?>
                    </button>
                </div>

            </div>
        </div>

    </div>

</div>