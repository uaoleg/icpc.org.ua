<?php use common\models\User; ?>

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
                                    <a href="#"><?=\yii::t('app', 'Region')?></a>
                                    <ul class="dropdown-menu dropup" role="menu">
                                        <li><a href="#" data-val="<?=User::COORD_REGION_CENTER?>"><?=\yii::t('app', 'Center')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_REGION_EAST?>"><?=\yii::t('app', 'East')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_REGION_NORTH?>"><?=\yii::t('app', 'North')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_REGION_SOUTH?>"><?=\yii::t('app', 'South')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_REGION_WEST?>"><?=\yii::t('app', 'West')?></a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a href="#"><?=\yii::t('app', 'State')?></a>
                                    <ul class="dropdown-menu dropdown-sorted" role="menu" style="margin-top: -350px;">
                                        <li><a href="#" data-val="<?=User::COORD_STATE_ARC?>"><?=\yii::t('app', 'ARC')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_CHERKASY?>"><?=\yii::t('app', 'Cherkasy')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_CHERNIHIV?>"><?=\yii::t('app', 'Chernihiv')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_CHERNIVTSI?>"><?=\yii::t('app', 'Chernivtsi')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_DNIPROPETROVSK?>"><?=\yii::t('app', 'Dnipropetrovsk')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_DONETSK?>"><?=\yii::t('app', 'Donetsk')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_IVANO_FRANKIVSK?>"><?=\yii::t('app', 'Ivano-Frankivsk')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_KHARKIV?>"><?=\yii::t('app', 'Kharkiv')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_KHERSON?>"><?=\yii::t('app', 'Kherson')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_KHMELNYTSKYI?>"><?=\yii::t('app', 'Khmelnytskyi')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_KIEV?>"><?=\yii::t('app', 'Kiev')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_KIROVOHRAD?>"><?=\yii::t('app', 'Kirovohrad')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_LUHANSK?>"><?=\yii::t('app', 'Luhansk')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_LVIV?>"><?=\yii::t('app', 'Lviv')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_MYKOLAIV?>"><?=\yii::t('app', 'Mykolaiv')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_ODESSA?>"><?=\yii::t('app', 'Odessa')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_POLTAVA?>"><?=\yii::t('app', 'Poltava')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_RIVNE?>"><?=\yii::t('app', 'Rivne')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_SUMY?>"><?=\yii::t('app', 'Sumy')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_TERNOPIL?>"><?=\yii::t('app', 'Ternopil')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_VINNYTSIA?>"><?=\yii::t('app', 'Vinnytsia')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_VOLYN?>"><?=\yii::t('app', 'Volyn')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_ZAKARPATTIA?>"><?=\yii::t('app', 'Zakarpattia')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_ZAPORIZHIA?>"><?=\yii::t('app', 'Zaporizhia')?></a></li>
                                        <li><a href="#" data-val="<?=User::COORD_STATE_ZHYTOMYR?>"><?=\yii::t('app', 'Zhytomyr')?></a></li>
                                    </ul>
                                </li>
                            </ul>
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