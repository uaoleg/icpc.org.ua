<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<script type="text/javascript">
    $(document).ready(function() {
        $('ul[data-sort=1]').sortList();
    });
</script>

<div class="btn-group">
    <a href="<?=Url::toRoute([\yii::$app->controller->action->id, 'geo' => $school->country])?>"
       class="btn btn-default <?=$countryChecked ? 'active' : ''?>">
        <?=$countryLabel?>
    </a>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle <?=$regionChecked ? 'active' : ''?>" data-toggle="dropdown">
            <?=$regionLabel?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <?php foreach (\common\models\Geo\Region::getConstants('NAME_') as $region): ?>
            <li><a href="<?=Url::toRoute([\yii::$app->controller->action->id, 'geo' => $region])?>">
                <?=\common\models\Geo\Region::getConstantLabel($region)?>
            </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle <?=$stateChecked ? 'active' : ''?>" data-toggle="dropdown">
            <?=$stateLabel?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" data-sort="1">
            <?php foreach (\common\models\Geo\State::getConstants('NAME_') as $state): ?>
            <li><a href="<?=Url::toRoute([\yii::$app->controller->action->id, 'geo' => $state])?>">
                <?=\common\models\Geo\State::getConstantLabel($state)?>
            </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>