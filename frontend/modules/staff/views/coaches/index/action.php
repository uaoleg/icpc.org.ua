<?php

/* @var $this   \yii\web\View */
/* @var $coach  \common\models\User */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div style="margin: 5px 0;">
    <button type="button" class="btn btn-success coach-state <?=$coach->isApprovedCoach ? 'hide' : ''?>"
        <?=(\yii::$app->user->can(\common\components\Rbac::OP_COACH_SET_STATUS, array('user' => $coach))) ? '' : 'disabled'?>
            data-state="1" data-uid="<?=$coach->id?>">
        <?=\yii::t('app', 'Activate')?>
    </button>
    <button type="button" class="btn btn-danger coach-state <?=$coach->isApprovedCoach ? '' : 'hide'?>"
        <?=(\yii::$app->user->can(\common\components\Rbac::OP_COACH_SET_STATUS, array('user' => $coach))) ? '' : 'disabled'?>
            data-state="0" data-uid="<?=$coach->id?>">
        <?=\yii::t('app', 'Suspend')?>
    </button>
</div>
