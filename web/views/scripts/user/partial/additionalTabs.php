<?php use \common\models\User; ?>

<?php if (in_array(\yii::app()->user->getInstance()->type, array(User::ROLE_COACH, User::ROLE_STUDENT))): ?>

    <?php \web\widgets\Nav::create(array(
        'class'      => 'nav nav-pills',
        'activeItem' => $this->getNavActiveItem('user'),
        'itemList'   => array(
            'me' => array(
                'href'      => $this->createUrl('/user/me'),
                'caption'   => \yii::t('app', 'General info'),
            ),
            'additionaluk' => array(
                'href'      => $this->createUrl('/user/additional', array('lang' => 'uk')),
                'caption'   => \yii::t('app', 'Additional info (ukrainian)'),
            ),
            'additionalen' => array(
                'href'      => $this->createUrl('/user/additional', array('lang' => 'en')),
                'caption'   => \yii::t('app', 'Additional info (english)'),
            ),
        ),
    )); ?>

    <br />

<?php endif; ?>