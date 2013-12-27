<?=\yii::t('app', 'Congrats! You\'ve been successfully registered on {app}.', array(
    '{app}' => \yii::app()->name,
))?>
<br />
<?=\yii::t('app', 'Please, confirm your email by following this link.')?>
<br />
<?=$link?>