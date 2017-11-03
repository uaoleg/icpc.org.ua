<?php

/* @var $this \yii\web\View */
/* @var $user \common\models\User */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div class="col-lg-offset-4 col-lg-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?=\yii::t('app', 'Set a new password')?></h3>
        </div>
        <div class="panel-body">
            <div class="form-horizontal col-lg-offset-1 col-lg-10">
                <input type="hidden" name="token" value="<?=$user->passwordResetToken?>" />
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="<?=$user->email?>" readonly="" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" value="" placeholder="<?=\yii::t('app', 'Password')?>" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="passwordRepeat" value="" placeholder="<?=\yii::t('app', 'Repeat password')?>" />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default reset-password"><?=\yii::t('app', 'Set a new password')?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        new appAuthPasswordResetToken();
    });
</script>
