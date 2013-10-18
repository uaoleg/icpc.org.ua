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
                    <div name="role" class="clearfix" style="margin-bottom: -20px;">
                        <div class="btn-group btn-group-justified" data-toggle="buttons">
                            <a class="btn btn-default active">
                                <input type="checkbox" name="type" value="<?=\common\models\User::ROLE_STUDENT?>" />
                                <?=\yii::t('app', 'I\'m a student')?>
                            </a>
                            <a class="btn btn-default">
                                <input type="checkbox" name="type" value="<?=\common\models\User::ROLE_COACH?>" />
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
                                    <li><a href="#" data-val="<?=User::COORD_UKRAINE?>"><?=\yii::t('app', 'Ukraine')?></a></li>
                                    <li class="dropdown-submenu">
                                        <span><?=\yii::t('app', 'Region')?></span>
                                        <ul class="dropdown-menu dropup" role="menu">
                                            <?php foreach (User::model()->getConstantList('COORD_REGION_') as $region): ?>
                                            <li><a href="#" data-val="<?=$region?>"><?=User::model()->getAttributeLabel($region)?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <span><?=\yii::t('app', 'State')?></span>
                                        <ul class="dropdown-menu dropdown-sorted" role="menu" style="margin-top: -350px;">
                                            <?php foreach (User::model()->getConstantList('COORD_STATE_') as $state): ?>
                                            <li><a href="#" data-val="<?=$state?>"><?=User::model()->getAttributeLabel($state)?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
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