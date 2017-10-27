<?php

/* @var $this           \yii\web\View */
/* @var $coordiantor    \common\models\User */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div style="margin: 5px 0;">
    <button type="button" class="btn btn-success coordinator-state <?=$coordiantor->isApprovedCoordinator ? 'hide' : ''?>"
        <?=(\yii::$app->user->can(\common\components\Rbac::OP_COORDINATOR_SET_STATUS, array('user' => $coordiantor))) ? '' : 'disabled'?>
            data-state="1" data-uid="<?=$coordiantor->id?>">
        <?=\yii::t('app', 'Activate')?>
    </button>
    <button type="button" class="btn btn-danger coordinator-state <?=$coordiantor->isApprovedCoordinator ? '' : 'hide'?>"
        <?=(\yii::$app->user->can(\common\components\Rbac::OP_COORDINATOR_SET_STATUS, array('user' => $coordiantor))) ? '' : 'disabled'?>
            data-state="0" data-uid="<?=$coordiantor->id?>">
        <?=\yii::t('app', 'Suspend')?>
    </button>
</div>