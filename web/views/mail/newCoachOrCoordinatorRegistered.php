<?php

/* @var $user \common\models\User */

?>

<p><?= \yii::t('app', 'A new user {name} in role of "{role}" registered and needs your approval.', array(
    '{name}' => "{$user->getFirstName()} {$user->getMiddleName()} {$user->getLastName()}",
    '{role}' => $user->type,
)) ?></p>

<p>
    <?= \yii::t('app', 'His email is {email}', array('{email}' => $user->email)) ?>
    <br>
    <?= \yii::t('app', 'His profile link is {url}', array('{url}' => \yii::app()->createAbsoluteUrl('/user/view', array('id' => $user->_id)))) ?>
</p>