<?php \yii::app()->clientScript->registerCoreScript('recaptcha'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appAuthPasswordReset();
    });
</script>

<div class="col-lg-offset-3 col-lg-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?=\yii::t('app', 'Password reset')?></h3>
        </div>
        <div class="panel-body">
            <div class="form-horizontal col-lg-offset-1 col-lg-10">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="" placeholder="<?=\yii::t('app', 'Email')?>">
                </div>
                <div class="form-group">
                    <div style="margin-left: -3px;">
                        <div class="g-recaptcha"
                             data-sitekey="<?= \yii::$app->params['recaptcha.publicKey'] ?>"
                             data-callback="appSiteLoginRecaptchaCallback"></div>
                        <?php if (APP_ENV !== APP_ENV_PROD): ?>
                            <label>
                                <input type="checkbox" name="recaptchaIgnore" />
                                <?=\yii::t('app', 'Ignore recaptcha')?>
                            </label>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary reset-password"><?=\yii::t('app', 'Reset password')?></button>
                </div>
            </div>
        </div>
    </div>
</div>