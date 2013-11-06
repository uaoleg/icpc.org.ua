<script type="text/javascript">
    $(document).ready(function() {
        new appTeamManage({
            teamId: '<?=\yii::app()->request->getParam('id')?>'
        });
    });
</script>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">

        <div class="panel panel-primary panel-school">
            <div class="panel-heading">
                <?=\yii::t('app', 'School info')?>
            </div>

            <div class="panel-body form">

                <div class="form-group">
                    <p class="form-control-static"><b><?=date('Y')?></b>&nbsp;<?=\yii::t('app', 'year')?></p>
                </div>

                <div class="form-group">
<!--                    <label>--><?//=\yii::t('app', 'Full name of university (ukrainian)')?><!--</label>-->
                    <p class="form-control-static"><?=\CHtml::encode($school->fullNameUk)?></p>
                </div>

                <div class="form-group">
<!--                    <label for="shortNameUk">--><?//=\yii::t('app', 'Short name of university (ukrainian)')?><!--</label>-->
                    <input type="text" class="form-control" id="shortNameUk" name="shortNameUk"
                           placeholder="<?=\yii::t('app', 'Short name of university (ukrainian)')?>"
                           value="<?=\CHtml::encode($school->shortNameUk)?>"
                           <?=(!empty($school->shortNameUk)) ? ' disabled' : ''?>>
                </div>

                <div class="form-group">
<!--                    <label for="fullNameEn">--><?//=\yii::t('app', 'Full name of university (english)')?><!--</label>-->
                    <input type="text" class="form-control" id="fullNameEn" name="fullNameEn"
                           placeholder="<?=\yii::t('app', 'Full name of university (english)')?>"
                           value="<?=\CHtml::encode($school->fullNameEn)?>"
                           <?=(!empty($school->fullNameEn)) ? ' disabled' : ''?>>
                </div>

                <div class="form-group">
<!--                    <label for="shortNameEn">--><?//=\yii::t('app', 'Short name of university (english)')?><!--</label>-->
                    <input type="text" class="form-control" id="shortNameEn" name="shortNameEn"
                           placeholder="<?=\yii::t('app', 'Short name of university (english)')?>"
                           value="<?=\CHtml::encode($school->shortNameEn)?>"
                           <?=(!empty($school->shortNameEn)) ? ' disabled' : ''?>>
                </div>

                <hr>

                <div class="form-group">
                    <label for="name"><?=\yii::t('app', 'Name of a team')?></label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?=\CHtml::encode(substr($team->name, strlen($school->shortNameEn)))?>"
                           placeholder="<?=\yii::t('app', 'Name of your team')?>"/>
                </div>

                <div class="form-group">
                    <label for="teamNamePrefix"><?=\yii::t('app', 'Name of a team with prefix   ')?></label>
                    <input type="text" class="form-control" id="teamNamePrefix" name="teamNamePrefix"
                           value="<?=\CHtml::encode($team->name)?>"
                           placeholder="<?=\yii::t('app', 'Name of your team with prefix')?>" readonly/>
                </div>

                <div class="form-group">
                    <label for="member1"><?=\yii::t('app', 'First member')?></label>
                    <select name="member1" id="member1" class="form-control" data-placeholder="<?=\yii::t('app', 'First member')?>">
                        <option></option>
                        <?php foreach($members as $member): ?>
                            <?php if ((string)$member->_id !== (string)\yii::app()->user->getInstance()['_id']): ?>
                                <option value="<?=$member->_id?>"<?=($teamMembers[0] === (string)$member->_id) ? ' selected' : ''?>>
                                    <?=\CHtml::encode($member->lastName)?>&nbsp;<?=\CHtml::encode($member->firstName)?> (<?=\CHtml::encode($member->email)?>)
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="member2"><?=\yii::t('app', 'Second member')?></label>
                    <select name="member2" id="member2" class="form-control" data-placeholder="<?=\yii::t('app', 'Second member')?>">
                        <option></option>
                        <?php foreach($members as $member): ?>
                            <?php if ((string)$member->_id !== (string)\yii::app()->user->getInstance()['_id']): ?>
                                <option value="<?=$member->_id?>"<?=($teamMembers[1] === (string)$member->_id) ? ' selected' : ''?>>
                                    <?=\CHtml::encode($member->lastName)?>&nbsp;<?=\CHtml::encode($member->firstName)?> (<?=\CHtml::encode($member->email)?>)
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="member3"><?=\yii::t('app', 'Third member')?></label>
                    <select name="member3" id="member3" class="form-control" data-placeholder="<?=\yii::t('app', 'Third member')?>">
                        <option></option>
                        <?php foreach($members as $member): ?>
                            <?php if ((string)$member->_id !== (string)\yii::app()->user->getInstance()['_id']): ?>
                                <option value="<?=$member->_id?>"<?=($teamMembers[2] === (string)$member->_id) ? ' selected' : ''?>>
                                    <?=\CHtml::encode($member->lastName)?>&nbsp;<?=\CHtml::encode($member->firstName)?> (<?=\CHtml::encode($member->email)?>)
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="member4"><?=\yii::t('app', 'Fourth member')?></label>
                    <select name="member4" id="member4" class="form-control" data-placeholder="<?=\yii::t('app', 'Fourth member (reserve)')?>">
                        <option></option>
                        <?php foreach($members as $member): ?>
                            <?php if ((string)$member->_id !== (string)\yii::app()->user->getInstance()['_id']): ?>
                                <option value="<?=$member->_id?>"<?=($teamMembers[3] === (string)$member->_id) ? ' selected' : ''?>>
                                    <?=\CHtml::encode($member->lastName)?>&nbsp;<?=\CHtml::encode($member->firstName)?> (<?=\CHtml::encode($member->email)?>)
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="form-group">
                    <button class="btn btn-primary btn-lg btn-save">
                        <?=\yii::t('app', 'Save')?>
                    </button>
                </div>


            </div>
        </div>

    </div>

</div>