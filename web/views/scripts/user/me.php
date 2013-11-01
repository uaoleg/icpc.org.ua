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
                <div class="form col-lg-10 col-lg-offset-1">
                    <div class="form-group">
                        <label for="firstName"><?=\yii::t('app', 'First name')?></label>
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="<?=\yii::t('app', 'First name')?>" value="<?=$firstName?>">
                    </div>
                    <div class="form-group">
                        <label for="lastName"><?=\yii::t('app', 'Last name')?></label>
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="<?=\yii::t('app', 'Last name')?>" value="<?=$lastName?>">
                    </div>
                    <div class="form-group">
                        <label><?=\yii::t('app', 'Email')?></label>
                        <p class="form-control-static"><?=$email?></p>
                    </div>

                    <div class="form-group">
                        <label><?=\yii::t('app', 'School name')?></label>
                        <select class="form-control" name="schoolId" id="schoolId" data-placeholder="Оберіть ВНЗ (українською)">
                            <option value=""></option>
                            <?php foreach($schools as $school): ?>
                                <option value="<?=$school->_id?>"<?=($schoolId === $school->_id) ? ' selected' : ''?>>
                                    <?=$school->fullNameUk?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <div name="role" class="clearfix" style="margin-bottom: -20px;">
                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                <a class="btn btn-default<?=($type === \common\models\User::ROLE_STUDENT) ? ' active' : ''?>">
                                    <input type="checkbox" name="type" value="student">
                                    I'm a student                            </a>
                                <a class="btn btn-default<?=($type === \common\models\User::ROLE_COACH) ? ' active' : '' ?>">
                                    <input type="checkbox" name="type" value="coach">
                                    I'm a coach                            </a>
                                <a class="btn btn-default<?=($type === \common\models\User::ROLE_COACH) ? ' active' : ''?>">
                                    <input type="checkbox" name="coordinator" value="coordinator_region">
                                    <span class="caption"><?=$coordinator?></span>
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

                    <div class="form-group">
                        <label for="currentPassword"><?=\yii::t('app', 'Current password (if you want to change it)')?></label>
                        <input type="password" class="form-control input-sm" id="currentPassword" name="currentPassword">
                    </div>
                    <div class="form-group">
                        <label for="newPassword"><?=\yii::t('app', 'New password')?></label>
                        <input type="password" class="form-control input-sm" id="newPassword" name="newPassword">
                    </div>
                    <div class="form-group">
                        <label for="repeatNewPassword"><?=\yii::t('app', 'Repeat new password')?></label>
                        <input type="password" class="form-control input-sm" id="repeatNewPassword" name="repeatNewPassword">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-save"><?=\yii::t('app', 'Save')?></button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>