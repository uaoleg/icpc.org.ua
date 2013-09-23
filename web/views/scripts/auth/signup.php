<div class="col-lg-offset-4 col-lg-5">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?=\yii::t('app', 'Signup')?></h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="post">
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <input type="text" class="form-control" name="firstName" value="<?=\CHtml::encode($firstName)?>" placeholder="<?=\yii::t('app', 'First Name')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <input type="text" class="form-control" name="lastName" value="<?=\CHtml::encode($lastName)?>" placeholder="<?=\yii::t('app', 'Last Name')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <input type="email" class="form-control" name="email" value="<?=\CHtml::encode($email)?>" placeholder="<?=\yii::t('app', 'Email')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <input type="password" class="form-control" name="password" value="<?=\CHtml::encode($password)?>" placeholder="<?=\yii::t('app', 'Password')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <input type="password" class="form-control" name="passwordRepeat" value="<?=\CHtml::encode($passwordRepeat)?>" placeholder="<?=\yii::t('app', 'Repeat password')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                    <?php $this->widget('common.lib.recaptcha.EReCaptcha', array(
                        'language'  => 'en_EN',
                        'theme'     => 'white',
                    )); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="rulesAgree" class="checkbox" <?=$rulesAgree ? 'checked' : ''?> />
                                <?=\yii::t('app', 'I agree with rules of the service')?>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-10">
                        <button type="submit" class="btn btn-primary"><?=\yii::t('app', 'Sign up')?></button>
                    </div>
                </div>
            </form>
            <?php if (count($errors) > 0): ?>
                <pre><?php var_dump($errors); ?></pre>
            <?php endif; ?>
        </div>
    </div>
</div>