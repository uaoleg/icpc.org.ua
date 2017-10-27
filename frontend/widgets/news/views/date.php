<?php

/* @var $this \yii\web\View */
/* @var $news \common\models\News */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<?=date('Y-m-d H:i', $news->timeCreated)?>