<?php

/* @var $this   \yii\web\View */
/* @var $tag    string */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<a href="<?=Url::toRoute(['/qa/latest', 'tag' => $tag]); ?>">
    <span class="label label-default"><?=Html::encode($tag)?></span></a>