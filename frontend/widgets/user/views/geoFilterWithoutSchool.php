<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<span class="label label-danger"><?=\yii::t('app', 'To manage news, you must specify your school on the {a}profile page{/a}.', array(
    'a'  => '<a href="' . Url::toRoute(['/user/me']) . '">',
    '/a' => '</a>',
))?></span>