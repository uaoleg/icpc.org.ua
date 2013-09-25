<script type="text/javascript">
    $(document).ready(function() {
        new appAuthSignup();
    });
</script>

<div class="col-lg-offset-4 col-lg-5">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?=\yii::t('app', 'Signup')?></h3>
        </div>
        <div class="panel-body">
            <div class="form-horizontal col-lg-offset-1 col-lg-10">
                <div class="form-group">
                    <input type="text" class="form-control" name="firstName" value="<?=\CHtml::encode($firstName)?>" placeholder="<?=\yii::t('app', 'First Name')?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="lastName" value="<?=\CHtml::encode($lastName)?>" placeholder="<?=\yii::t('app', 'Last Name')?>">
                </div>
                <div class="form-group">
                        <input type="email" class="form-control" name="email" value="<?=\CHtml::encode($email)?>" placeholder="<?=\yii::t('app', 'Email')?>">
                </div>
                <div class="form-group">
                        <input type="password" class="form-control" name="password" value="<?=\CHtml::encode($password)?>" placeholder="<?=\yii::t('app', 'Password')?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="passwordRepeat" value="<?=\CHtml::encode($passwordRepeat)?>" placeholder="<?=\yii::t('app', 'Repeat password')?>">
                </div>
                <div class="form-group">
                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-default active">
                            <input type="radio" name="role" value="<?=\common\models\User::ROLE_STUDENT?>" />
                            <?=\yii::t('app', 'I\'m a student')?>
                        </label>
                        <label class="btn btn-default">
                            <input type="radio" name="role" value="<?=\common\models\User::ROLE_TEACHER?>" />
                            <?=\yii::t('app', 'I\'m a teacher')?>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div style="margin-left: -3px;">
                        <?php $this->widget('common.lib.recaptcha.EReCaptcha', array(
                            'language'  => 'en_EN',
                            'theme'     => 'white',
                        )); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="rulesAgree" class="checkbox" <?=$rulesAgree ? 'checked' : ''?> />
                            <?=\yii::t('app', 'I agree with rules of the service')?>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary signup"><?=\yii::t('app', 'Sign up')?></button>
                </div>
            </div>
        </div>
    </div>
</div>