<?php

/* @var $this \yii\web\View */

use \common\models\User;
use \yii\helpers\Html;
use \yii\helpers\Url;

$this->registerJsFile('@web/lib/plupload-834/js/plupload.full.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/lib/plupload-834/js/jquery.plupload.queue/jquery.plupload.queue.min.js', ['position' => \yii\web\View::POS_HEAD]);

?>

<script type="text/javascript">
    $(document).ready(function() {
        new appUserMe();
    });
</script>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">

        <?= $this->render('partial/additional-tabs'); ?>

        <div class="panel panel-primary">

            <div class="panel-body">
                <div class="form-horizontal">

                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-2">
                                <?=\frontend\widgets\user\Photo::widget(array('photo' => $user->photo))?>
                            </div>
                            <div class="col-lg-10" id="uploadContainer">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm" id="uploadPickfiles">
                                        <?=\yii::t('app', 'Upload photo')?>
                                    </button>
                                    <span class="document-origin-filename"></span>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="row">
                        <label class="col-lg-2 control-label"><?=\yii::t('app', 'First name')?></label>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="firstNameUk" name="firstNameUk"
                                           value="<?=Html::encode($user->firstNameUk)?>" placeholder="Ім'я (українською)">
                                    <span class="input-group-addon"><span class="img-language-uk-16"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <div class="input-group">
                                <input type="text" class="form-control" id="firstNameEn" name="firstNameEn"
                                       value="<?=Html::encode($user->firstNameEn)?>" placeholder="First name (english)"
                                       data-baylor-firstName="">
                                <span class="input-group-addon"><span class="img-language-en-16"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-lg-2 control-label"><?=\yii::t('app', 'Middle name')?></label>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="middleNameUk" name="middleNameUk"
                                           value="<?=Html::encode($user->middleNameUk)?>" placeholder="По-батьковi (українською)">
                                    <span class="input-group-addon"><span class="img-language-uk-16"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="middleNameEn" name="middleNameEn"
                                           value="<?=Html::encode($user->middleNameEn)?>" placeholder="Middle name (english)">
                                    <span class="input-group-addon"><span class="img-language-en-16"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-lg-2 control-label"><?=\yii::t('app', 'Last name')?></label>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="lastNameUk" name="lastNameUk"
                                           value="<?=Html::encode($user->lastNameUk)?>" placeholder="Прізвище (українською)">
                                    <span class="input-group-addon"><span class="img-language-uk-16"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="lastNameEn" name="lastNameEn"
                                           value="<?=Html::encode($user->lastNameEn)?>" placeholder="Last name (english)"
                                           data-baylor-lastName="">
                                    <span class="input-group-addon"><span class="img-language-en-16"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?=\yii::t('app', 'School name')?></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="schoolId" id="schoolId" data-placeholder="Оберіть ВНЗ (українською)">
                                    <option value=""></option>
                                    <?php foreach ($schools as $school): ?>
                                        <option value="<?=$school->id?>" <?=((int)$school->id === (int)$user->schoolId) ? 'selected' : ''?>>
                                            <?=$school->fullNameUk?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label class="col-lg-2 control-label"><?=\yii::t('app', 'Roles')?></label>
                            <div class="col-lg-10">
                                <div name="role" class="clearfix" style="margin-bottom: -20px;">
                                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                                        <a class="btn btn-default <?=($user->type === \common\models\User::ROLE_STUDENT) ? 'active' : ''?>">
                                            <input type="checkbox" name="type" value="<?=User::ROLE_STUDENT?>">
                                            <?=\yii::t('app', 'I\'m a student')?>
                                        </a>
                                        <a class="btn btn-default <?=($user->type === \common\models\User::ROLE_COACH) ? 'active' : '' ?>">
                                            <input type="checkbox" name="type" value="<?=User::ROLE_COACH?>">
                                            <?=\yii::t('app', 'I\'m a coach')?>
                                        </a>
                                        <a class="btn btn-default <?=(!empty($user->coordinator)) ? 'active' : ''?>">
                                            <input type="checkbox" name="coordinator" value="<?=$user->coordinator?>">
                                            <span class="caption"><?=$coordinatorLabel?></span>
                                            <span class="caret"></span>
                                        </a>
                                    </div>
                                    <div class="btn-group" style="margin-top: -17px; width: 100%;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"></a>
                                            <ul class="dropdown-menu pull-right" role="menu" style="display: none;">
                                                <li><a href="#" data-val="<?=User::ROLE_COORDINATOR_UKRAINE?>"><?=\yii::t('app', 'Ukraine')?></a></li>
                                                <li><a href="#" data-val="<?=User::ROLE_COORDINATOR_REGION?>"><?=\yii::t('app', 'Region')?></a></li>
                                                <li><a href="#" data-val="<?=User::ROLE_COORDINATOR_STATE?>"><?=\yii::t('app', 'State')?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="role-statuses clearfix">
                                    <span class="label col-md-4 col-md-offset-4
                                        <?=($user->type === \common\models\User::ROLE_COACH) ? '' : 'invisible'?>
                                        <?=$user->isApprovedCoach ? 'label-success' : 'label-warning'?>
                                        "><?=$user->isApprovedCoach ? \yii::t('app', 'Approved') : \yii::t('app', 'Not approved');?></span>
                                    <span class="label col-md-4
                                        <?=(!empty($user->coordinator))  ? '' : 'invisible'?>
                                        <?=$user->isApprovedCoordinator ? 'label-success' : 'label-warning'?>
                                        "><?=$user->isApprovedCoordinator ? \yii::t('app', 'Approved') : \yii::t('app', 'Not approved');?></span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-2">
                                <button type="submit" class="btn btn-lg btn-primary js-save"><?=\yii::t('app', 'Save')?></button>
                                <?=\frontend\widgets\user\Baylor::widget()?>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="row">
                        <div class="form-group">
                            <label for="currentPassword" class="col-lg-3 control-label"><?=\yii::t('app', 'Current password')?></label>
                            <div class="col-lg-9">
                                <input type="password" class="form-control input-sm" id="currentPassword" name="currentPassword">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="password" class="col-lg-3 control-label"><?=\yii::t('app', 'New password')?></label>
                            <div class="col-lg-9">
                                <input type="password" class="form-control input-sm" id="password" name="password">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="passwordRepeat" class="col-lg-3 control-label"><?=\yii::t('app', 'Repeat new password')?></label>
                            <div class="col-lg-9">
                                <input type="password" class="form-control input-sm" id="passwordRepeat" name="passwordRepeat">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="btn btn-lg btn-primary btn-save-password">
                                    <?=\yii::t('app', 'Change password')?>
                                </button>
                            </div>
                        </div>
                    </div>

                    <?php if (\yii::$app->user->getState('passwordChangeSuccess', null, true)): ?>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="alert alert-success">
                                        <?=\yii::t('app', 'Your password has been successfully changed');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
     </div>
</div>