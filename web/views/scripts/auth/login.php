<div class="col-lg-offset-4 col-lg-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?=\yii::t('app', 'Login')?></h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal col-lg-offset-1 col-lg-10" method="post">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?=$error?></div>
                <?php endif; ?>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="<?=$email?>" placeholder="<?=\yii::t('app', 'Email')?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="<?=\yii::t('app', 'Password')?>">
                </div>
                <div class="form-group">
                    <a href="<?=$this->createUrl('passwordReset')?>">
                        <?=\yii::t('app', 'Forgot your password?')?>
                    </a>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><?=\yii::t('app', 'Sign in')?></button>
                    <a href="<?=$this->createUrl('signup')?>" class="btn btn-default pull-right"><?=\yii::t('app', 'Register')?></a>
                </div>
            </form>
        </div>
    </div>
</div>