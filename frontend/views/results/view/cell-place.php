<?php

/* @var $this   \yii\web\View */
/* @var $result \common\models\Result */

use \common\models\Result;
use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div class="results-place-item">
    <span class="label label-default"
          title="<?=\yii::t('app', 'Absolute place')?>"
          rel="tooltip"
          data-placement="right">
        <?=$result->placeText?>
    </span>
</div>

<div class="results-place-item">
    <?php if (($result->team !== null) && (\yii::$app->user->can(\common\components\Rbac::OP_TEAM_PHASE_UPDATE))): ?>
        <input type="checkbox"
               <?=$result->phaseIsCompleted ? 'checked' : ''?>
               class="results-phase-completed"
               title="<?=\yii::t('app', 'Proceeded to the next stage')?>"
               rel="tooltip"
               data-placement="right"
               data-team-id="<?=$result->teamId?>" />
    <?php elseif ($result->phaseIsCompleted): ?>
        <span class="glyphicon glyphicon-ok"
               title="<?=\yii::t('app', 'Proceeded to the next stage')?>"
               rel="tooltip"
               data-placement="right"></span>
    <?php endif; ?>
</div>

<div class="results-place-item">
    <?php if (\yii::$app->user->can(\common\components\Rbac::OP_RESULT_CREATE)): ?>
        <select class="results-prize-place"
                title="<?=\yii::t('app', 'Prize place')?>"
                rel="tooltip"
                data-placement="right">
            <option value="<?=Result::PRIZE_PLACE_NO?>">-</option>
            <?php for ($i = Result::PRIZE_PLACE_1; $i < Result::PRIZE_PLACE_NO; $i++): ?>
            <option value="<?=$i?>" <?=$result->prizePlace === $i ? 'selected' : ''?>>
                <?=$i?>
            </option>
            <?php endfor; ?>
        </select>
    <?php elseif ($result->prizePlace < Result::PRIZE_PLACE_NO): ?>
        <span class="label label-success"
              title="<?=\yii::t('app', 'Prize place')?>"
              rel="tooltip"
              data-placement="right">
            <?=$result->prizePlace?>
        </span>
    <?php endif; ?>
</div>