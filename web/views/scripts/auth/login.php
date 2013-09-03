<div class="col-lg-offset-4 col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?=\yii::t('app', 'Login')?></h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="post">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?=$error?></div>
                <?php endif; ?>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <input type="email" class="form-control" name="email" value="<?=$email?>" placeholder="<?=\yii::t('app', 'Email')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <input type="password" class="form-control" name="password" placeholder="<?=\yii::t('app', 'Password')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <button type="submit" class="btn btn-default"><?=\yii::t('app', 'Sign in')?></button>
                        <a href="<?=$this->createUrl('signup')?>" class="btn btn-link pull-right"><?=\yii::t('app', 'register')?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>