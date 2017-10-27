<?php

/* @var $this \yii\web\View */

use \common\models\User;
use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<script type="text/javascript">
    $(document).ready(function() {
        new appAuthSignup();
    });
</script>

<div class="row">
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
                    <input type="hidden" name="dateOfBirth" data-baylor-birthday="" />
                    <input type="hidden" name="speciality" data-baylor-speciality="" />
                    <div class="form-group">
                        <input type="text" class="form-control" name="firstNameUk"
                               value="<?=Html::encode($user->firstNameUk)?>"
                               placeholder="<?=$user->getAttributeLabel('firstNameUk')?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="middleNameUk"
                               value="<?=Html::encode($user->middleNameUk)?>"
                               placeholder="<?=$user->getAttributeLabel('middleNameUk')?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="lastNameUk"
                               value="<?=Html::encode($user->lastNameUk)?>"
                               placeholder="<?=$user->getAttributeLabel('lastNameUk')?>">
                    </div>
                    <div class="form-group">
                            <input type="email" class="form-control" name="email"
                                   value="<?=Html::encode($user->email)?>"
                                   placeholder="<?=$user->getAttributeLabel('email')?>"
                                   data-baylor-email="">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password"
                               value="<?=Html::encode($password)?>"
                               placeholder="<?=\yii::t('app', 'Password')?>">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="passwordRepeat"
                               value="<?=Html::encode($passwordRepeat)?>"
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
                               data-formatnomatches="<?=\yii::t('app', 'No matches found. Please, try to search by a part of your school\'s name, not by the full name.<br><br>If you not succeeded, please, contact your coach or coordinator with request to add your school to the list.')?>"
                               data-placeholder="<?=\yii::t('app', 'Your school')?>" />
                    </div>
                    <div class="form-group">
                        <div style="margin-left: -3px;">
                            <div class="g-recaptcha"
                                 data-sitekey="<?= \yii::$app->params['recaptcha.publicKey'] ?>"
                                 data-callback="appSiteLoginRecaptchaCallback"></div>
                            <?php if (\YII_ENV !== \YII_ENV_PROD): ?>
                                <label>
                                    <input type="checkbox" name="recaptchaIgnore" />
                                    <?=\yii::t('app', 'Ignore recaptcha')?>
                                </label>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="rulesAgree" <?=$rulesAgree ? 'checked' : ''?> />
                                <?=\yii::t('app', 'I agree with {a}rules of the service{/a}', array(
                                    'a'   => '<a href="' . Url::toRoute(['/page/agreement']) . '" target="_blank">',
                                    '/a'  => '</a>',
                                ))?>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="signup btn btn-primary btn-lg">
                            <?=\yii::t('app', 'Sign up')?>
                        </button>
                        <?=\frontend\widgets\user\Baylor::widget()?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="panel panel-default js-baylor-panel hide">
            <div class="panel-heading">
                <h3 class="panel-title"><?=\yii::t('app', 'Data from icpc.baylor.edu')?></h3>
            </div>
            <div class="panel-body">
                <div class="form-group hide" data-baylor-firstName-text="">
                    <label><?=$user->getAttributeLabel('firstNameEn')?></label>
                    <p class="form-control-static"></p>
                </div>
                <div class="form-group hide" data-baylor-lastName-text="">
                    <label><?=$user->getAttributeLabel('lastNameEn')?></label>
                    <p class="form-control-static"></p>
                </div>
                <div class="form-group hide" data-baylor-birthday-text="">
                    <label><?=$user->getAttributeLabel('dateOfBirth')?></label>
                    <p class="form-control-static"></p>
                </div>
                <div class="form-group hide" data-baylor-acmId-text="">
                    <label><?=$user->getAttributeLabel('acmNumber')?></label>
                    <p class="form-control-static"></p>
                </div>
                <div class="form-group hide" data-baylor-phoneHome-text="">
                    <label><?=$user->getAttributeLabel('phoneHome')?></label>
                    <p class="form-control-static"></p>
                </div>
                <div class="form-group hide" data-baylor-phoneMobile-text="">
                    <label><?=$user->getAttributeLabel('phoneMobile')?></label>
                    <p class="form-control-static"></p>
                </div>
                <div class="form-group hide" data-baylor-speciality-text="">
                    <label><?=$user->getAttributeLabel('speciality')?></label>
                    <p class="form-control-static"></p>
                </div>
            </div>
        </div>
    </div>
</div>