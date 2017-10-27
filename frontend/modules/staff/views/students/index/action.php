<?php

/* @var $this       \yii\web\View */
/* @var $student    \common\models\User */

use \yii\helpers\Html;
use \yii\helpers\Url;

$isAdmin = \yii::$app->user->can(\common\models\User::ROLE_ADMIN);

?>

<div style="margin: 5px 0;">
    <button type="button" class="btn btn-success student-state <?=$student->isApprovedStudent ? 'hide' : ''?>"
        <?=(\yii::$app->user->can(\common\components\Rbac::OP_STUDENT_SET_STATUS)) ? '' : 'disabled'?>
            data-state="1" data-uid="<?=$student->id?>">
        <?= $isAdmin ? \yii::t('app', 'Activate') : \yii::t('app', 'Undo') ?>
    </button>
    <button type="button" class="btn btn-danger student-state <?=$student->isApprovedStudent ? '' : 'hide'?>"
        <?=(\yii::$app->user->can(\common\components\Rbac::OP_STUDENT_SET_STATUS)) ? '' : 'disabled'?>
            data-state="0" data-uid="<?=$student->id?>">
        <?= $isAdmin ? \yii::t('app', 'Suspend') : \yii::t('app', 'Delete') ?>
    </button>
</div>