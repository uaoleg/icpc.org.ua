<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <?= $this->render('partial/additional-tabs'); ?>
        <div class="alert alert-info"><?=\yii::t('app', 'No additional information for you.')?></div>
    </div>
</div>