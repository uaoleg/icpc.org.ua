<?php

/* @var $this       \yii\web\View */
/* @var $name       string */
/* @var $message    string */
/* @var $exception  \Exception */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div class="col-lg-offset-4 col-lg-4">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title"><?=$name?></h3>
        </div>
        <div class="panel-body">
            <strong><?=$message?></strong>
        </div>
    </div>
</div>