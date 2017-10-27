<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div class="qa-answer">
    <div>
        <?=$answer->content?>
    </div>
    <div class="clearfix">
        <div class="pull-right">
            <a href="<?=Url::toRoute(['/user/view', 'id' => $answer->user->id])?>">
                <?=\frontend\widgets\user\Name::widget(array('user' => $answer->user))?></a>
            <br />
            <span class="text-muted"><?=date('Y-m-d H:i:s', $answer->timeCreated)?></span>
        </div>
    </div>
    <hr />
</div>
