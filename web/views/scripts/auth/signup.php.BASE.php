<?php use common\models\User; ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appAuthSignup();
    });
</script>

<div class="col-lg-offset-3 col-lg-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?=\yii::t('app', 'Signup')?></h3>
        </div>
        <div class="panel-body">
            <div class="form-horizontal col-lg-offset-1 col-lg-10">
                <input type="hidden" name="firstNameEn" data-baylor-firstName="" />
                <input type="hidden" name="lastNameEn" data-baylor-lastName="" />
                <input type="hidden" name="acmId" data-baylor-acmId="" />
                <input type="hidden" name="phoneHome" data-baylor-phoneHome="" />
                <input type="hidden" name="phoneMobile" data-baylor-phoneMobile="" />
                <input type="hidden" name="shirtSize" data-baylor-shirtSize="" />
                <div class="form-group">
                    <input type="text" class="form-control" name="firstNameUk"
                           value="<?=\CHtml::encode($user->firstNameUk)?>"
                           placeholder="<?=$user->getAttributeLabel('firstNameUk')?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="middleNameUk"
                           value="<?=\CHtml::encode($user->middleNameUk)?>"
                           placeholder="<?=$user->getAttributeLabel('middleNameUk')?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="lastNameUk"
                           value="<?=\CHtml::encode($user->lastNameUk)?>"
                           placeholder="<?=$user->getAttributeLabel('lastNameUk')?>">
                </div>
                <div class="form-group">
                        <input type="email" class="form-control" name="email"
                               value="<?=\CHtml::encode($user->email)?>"
                               placeholder="<?=$user->getAttributeLabel('email')?>"
                               data-baylor-email="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password"
                           value="<?=\CHtml::encode($password)?>"
                           placeholder="<?=\yii::t('app', 'Password')?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="passwordRepeat"
                           value="<?=\CHtml::encode($passwordRepeat)?>"
                           placeholder="<?=\yii::t('app', 'Repeat password')?>">
                </div>
                <div class="form-group">
                    <div name="role" class="clearfix" style="margin-bottom: -20px;">
                        <div class="btn-group btn-group-justified" data-toggle="buttons">
                            <a class="btn btn-default active">
                                <input type="checkbox" name="type" value="<?=User::ROLE_STUDENT?>" />
                                <?=\yii::t('app', 'I\'m a student')?>
                            </a>
                            <a class="btn btn-default">
                                <input type="checkbox" name="type" value="<?=User::ROLE_COACH?>" />
                                <?=\yii::t('app', 'I\'m a coach')?>
                            </a>
                            <a class="btn btn-default">
                                <input type="checkbox" name="coordinator" value="" />
                                <span class="caption"><?=\yii::t('app', 'Coordinator')?></span>
                                <span class="caret"></span>
                            </a>
                        </div>
                        <div class="btn-group" style="margin-top: -17px; width: 100%;">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"></a>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a href="#" data-val="<?=User::ROLE_COORDINATOR_UKRAINE?>"><?=\yii::t('app', 'Ukraine')?></a></li>
                                    <li><a href="#" data-val="<?=User::ROLE_COORDINATOR_REGION?>"><?=\yii::t('app', 'Region')?></a></li>
                                    <li><a href="#" data-val="<?=User::ROLE_COORDINATOR_STATE?>"><?=\yii::t('app', 'State')?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden"
                           name="schoolId"
                           class="form-control"
                           data-placeholder="<?=\yii::t('app', 'Your school')?>" />
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
                            <input type="checkbox" name="rulesAgree" <?=$rulesAgree ? 'checked' : ''?> />
                            <?=\yii::t('app', 'I agree with {a}rules of the service{/a}', array(
                                '{a}'   => '<a href="' . $this->createUrl('/page/agreement') . '" target="_blank">',
                                '{/a}'  => '</a>',
                            ))?>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="signup btn btn-primary btn-lg">
                        <?=\yii::t('app', 'Sign up')?>
                    </button>
                    <?php \web\widgets\user\Baylor::create(); ?>
                </div>
            </div>
        </div>
    </div>
</div>