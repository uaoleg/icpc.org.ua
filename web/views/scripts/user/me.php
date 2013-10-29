<script type="text/javascript">
    $(document).ready(function() {
        new appUserMe();
    });
</script>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <div class="panel panel-primary">

            <div class="panel-heading">
                Info
            </div>

            <div class="panel-body">
                <div class="form col-lg-10 col-lg-offset-1">
                    <div class="form-group">
                        <label for="firstName"><?=\yii::t('app', 'First name')?></label>
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="<?=\yii::t('app', 'First name')?>" value="<?=$firstName?>">
                    </div>
                    <div class="form-group">
                        <label for="lastName"><?=\yii::t('app', 'Last name')?></label>
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="<?=\yii::t('app', 'Last name')?>" value="<?=$lastName?>">
                    </div>
                    <div class="form-group">
                        <label><?=\yii::t('app', 'Email')?></label>
                        <p class="form-control-static"><?=$email?></p>
                    </div>
                    <div class="form-group">
                        <label for="currentPassword"><?=\yii::t('app', 'Current password (if you want to change it)')?></label>
                        <input type="password" class="form-control input-sm" id="currentPassword" name="currentPassword">
                    </div>
                    <div class="form-group">
                        <label for="newPassword"><?=\yii::t('app', 'New password')?></label>
                        <input type="password" class="form-control input-sm" id="newPassword" name="newPassword">
                    </div>
                    <div class="form-group">
                        <label for="repeatNewPassword"><?=\yii::t('app', 'Repeat new password')?></label>
                        <input type="password" class="form-control input-sm" id="repeatNewPassword" name="repeatNewPassword">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-save"><?=\yii::t('app', 'Save')?></button>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>