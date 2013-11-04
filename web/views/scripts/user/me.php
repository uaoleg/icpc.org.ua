<?php use common\models\User; ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appUserMe();
    });
</script>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <div class="panel panel-primary">

            <div class="panel-heading">
                <?=\yii::t('app', 'Profile info')?>
            </div>

            <div class="panel-body">
                <div class="form-horizontal">

                    <div class="form-group">
                        <label for="firstName" class="col-lg-3 control-label"><?=\yii::t('app', 'First name')?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?=\CHtml::encode($firstName)?>" placeholder="Ім'я (українською)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="col-lg-3 control-label"><?=\yii::t('app', 'Last name')?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?=\CHtml::encode($lastName)?>" placeholder="Прізвище (українською)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=\yii::t('app', 'Email')?></label>
                        <div class="col-lg-9">
                            <p class="form-control-static"><?=$email?></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=\yii::t('app', 'School name')?></label>
                        <div class="col-lg-9">
                            <select class="form-control" name="schoolId" id="schoolId" data-placeholder="Оберіть ВНЗ (українською)">
                                <option value=""></option>
                                <?php foreach ($schools as $school): ?>
                                    <option value="<?=$school->_id?>" <?=($schoolId == $school->_id) ? 'selected' : ''?>>
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
                                    <a class="btn btn-default<?=($type === \common\models\User::ROLE_STUDENT) ? ' active' : ''?>">
                                        <input type="checkbox" name="type" value="<?=User::ROLE_STUDENT?>">
                                        <?=\yii::t('app', 'I\'m a student')?>
                                    </a>
                                    <a class="btn btn-default<?=($type === \common\models\User::ROLE_COACH) ? ' active' : '' ?>">
                                        <input type="checkbox" name="type" value="<?=User::ROLE_COACH?>">
                                        <?=\yii::t('app', 'I\'m a coach')?>
                                    </a>
                                    <a class="btn btn-default<?=(!empty($coordinator)) ? ' active' : ''?>">
                                        <input type="checkbox" name="coordinator" value="<?=$coordinator?>">
                                        <span class="caption"><?=$coordinatorLabel?></span>
                                        <span class="caret"></span>
                                    </a>
                                </div>
                                <div class="btn-group" style="margin-top: -17px; width: 100%;">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"></a>
                                        <ul class="dropdown-menu pull-right" role="menu" style="display: none;">
                                            <li><a href="#" data-val="coordinator_ukraine">Ukraine</a></li>
                                            <li><a href="#" data-val="coordinator_region">Region</a></li>
                                            <li><a href="#" data-val="coordinator_state">State</a></li>
                                        </ul>
                                    </div>
                                </div>
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
                            <button class="btn btn-lg btn-primary btn-save"><?=\yii::t('app', 'Save')?></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>