<script type="text/javascript">
    $(document).ready(function() {
        new appAuthLogin();
    });
</script>

<div class="col-lg-offset-4 col-lg-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?=\yii::t('app', 'Login')?></h3>
        </div>
        <div class="panel-body">
            <form class="auth-login form-horizontal col-lg-offset-1 col-lg-10" method="post">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger js-auth-login-error">
                        <p><?=$error?></p>
                        <?php if ($confirmation !== null): ?>
                            <br>
                            <button type="button" class="btn btn-default btn-block js-auth-login-resend-confirmation-email" data-id="<?= $confirmation->_id ?>">
                                <?=\yii::t('app', 'Resend confirmation email')?>
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="alert alert-success fade in hide js-auth-login-resend-success">
                        <strong><?=\yii::t('app', 'E-mail was resent successfully!')?></strong>
                    </div>
                    <div class="alert alert-warning fade in hide js-auth-login-resend-failed">
                        <strong><?=\yii::t('app', 'E-mail confirmation request can be sent no more than 1 time per day.')?></strong>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="<?=$email?>" placeholder="<?=\yii::t('app', 'Email')?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="<?=\yii::t('app', 'Password')?>">
                    <a href="<?=$this->createUrl('passwordReset')?>" rel="tooltip" title="<?=\yii::t('app', 'Forgot your password?')?>">
                        ?
                    </a>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <?=\yii::t('app', 'Sign in')?>
                    </button>
                    <hr />
                    <?=\yii::t('app', 'Do not have an account?')?>
                    <br />
                    <b><a href="<?=$this->createUrl('signup')?>"><?=\yii::t('app', 'Register now!')?></a></b>
                </div>
            </form>
        </div>
    </div>
</div>