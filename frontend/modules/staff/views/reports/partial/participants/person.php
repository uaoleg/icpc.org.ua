<?php

/* @var $this   \yii\web\View */
/* @var $user   \common\models\User */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<td>
    <?= \frontend\widgets\user\Name::widget(['user' => $user, 'lang' => 'uk']) ?>
</td>
<td>
    <?= \frontend\widgets\user\Name::widget(['user' => $user, 'lang' => 'en']) ?>
</td>
<td><?=$user->email?></td>
<td>
    <?php if (!empty($user->info->phoneMobile)): ?>
        <?=\yii::t('app', 'Mobile phone')?>:<?=$user->info->phoneMobile?>
        <br />
    <?php endif; ?>
    <?php if (!empty($user->info->phoneMobile)): ?>
        <?=\yii::t('app', 'Home phone')?>:<?=$user->info->phoneHome?>
    <?php endif; ?>
</td>
<td><?=$user->info->tShirtSize?></td>
<td><?=$user->info->dateOfBirth?></td>
<td><?=(isset($user->info->schoolAdmissionYear)) ? $user->info->schoolAdmissionYear : ''?></td>
<td><?=(isset($user->info->course)) ? $user->info->course : ''?></td>