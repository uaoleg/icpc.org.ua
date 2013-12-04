<?php use common\models\User; ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appUserMe();
    });
</script>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <?php $this->renderPartial('partial/additionalTabs'); ?>

        <div class="panel panel-primary">

            <div class="panel-body">
                <div class="form-horizontal">

                    <div class="form-group">
                        <label for="firstNameUk" class="col-lg-3 control-label"><?=\yii::t('app', 'First name (ukranian)')?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="firstNameUk" name="firstNameUk"
                                   value="<?=\CHtml::encode($user->firstNameUk)?>" placeholder="Ім'я (українською)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="middleNameUk" class="col-lg-3 control-label"><?=\yii::t('app', 'Middle name (ukranian)')?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="middleNameUk" name="middleNameUk"
                                   value="<?=\CHtml::encode($user->middleNameUk)?>" placeholder="По-батьковi (українською)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastNameUk" class="col-lg-3 control-label"><?=\yii::t('app', 'Last name (ukranian)')?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="lastNameUk" name="lastNameUk"
                                   value="<?=\CHtml::encode($user->lastNameUk)?>" placeholder="Прізвище (українською)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstNameEn" class="col-lg-3 control-label"><?=\yii::t('app', 'First name (english)')?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="firstNameEn" name="firstNameEn"
                                   value="<?=\CHtml::encode($user->firstNameEn)?>" placeholder="First name (english)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="middleNameEn" class="col-lg-3 control-label"><?=\yii::t('app', 'Middle name (english)')?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="middleNameEn" name="middleNameEn"
                                   value="<?=\CHtml::encode($user->middleNameEn)?>" placeholder="Middle name (english)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastNameEn" class="col-lg-3 control-label"><?=\yii::t('app', 'Last name (english)')?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="lastNameEn" name="lastNameEn"
                                   value="<?=\CHtml::encode($user->lastNameEn)?>" placeholder="Last name (english)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=\yii::t('app', 'Email')?></label>
                        <div class="col-lg-9">
                            <p class="form-control-static"><?=$user->email?></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=\yii::t('app', 'School name')?></label>
                        <div class="col-lg-9">
                            <select class="form-control" name="schoolId" id="schoolId" data-placeholder="Оберіть ВНЗ (українською)">
                                <option value=""></option>
                                <?php foreach ($schools as $school): ?>
                                    <option value="<?=$school->_id?>" <?=((string)$school->_id === $user->schoolId) ? 'selected' : ''?>>
                                        <?=$school->fullNameUk?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=\yii::t('app', 'Roles')?></label>
                        <div class="col-lg-9">
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

                    <hr />

                    <div class="form-group">
                        <label for="currentPassword" class="col-lg-3 control-label"><?=\yii::t('app', 'Current password')?></label>
                        <div class="col-lg-9">
                            <input type="password" class="form-control input-sm" id="currentPassword" name="currentPassword">
                            <div class="help-block">
                                <?=\yii::t('app', 'Set only if you want to change it')?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-lg-3 control-label"><?=\yii::t('app', 'New password')?></label>
                        <div class="col-lg-9">
                            <input type="password" class="form-control input-sm" id="password" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="passwordRepeat" class="col-lg-3 control-label"><?=\yii::t('app', 'Repeat new password')?></label>
                        <div class="col-lg-9">
                            <input type="password" class="form-control input-sm" id="passwordRepeat" name="passwordRepeat">
                        </div>
                    </div>

                    <hr />

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-lg btn-primary btn-save"><?=\yii::t('app', 'Save')?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>