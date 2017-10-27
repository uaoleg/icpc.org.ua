<?php

/* @var $this \yii\web\View */

use \common\models\User;
use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<?php if (in_array(\yii::$app->user->identity->type, array(User::ROLE_COACH, User::ROLE_STUDENT))): ?>

    <?=\frontend\widgets\Nav::widget(array(
        'cssClass'   => 'nav nav-pills',
        'activeItem' => \yii::$app->controller->getNavActiveItem('user'),
        'itemList'   => array(
            'me' => array(
                'href'      => Url::toRoute(['/user/me']),
                'caption'   => \yii::t('app', 'General info'),
            ),
            'additionaluk' => array(
                'href'      => Url::toRoute(['/user/additional', 'lang' => 'uk']),
                'caption'   => \yii::t('app', 'Additional info (ukrainian)'),
            ),
            'additionalen' => array(
                'href'      => Url::toRoute(['/user/additional', 'lang' => 'en']),
                'caption'   => \yii::t('app', 'Additional info (english)'),
            ),
        ),
    ))?>

    <br />

<?php endif; ?>