<?php

/* @var $this       \yii\web\View */
/* @var $checked    string */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div class="btn-group">
    <?php if (\yii::$app->params['yearFirst'] < date('Y')): ?>
        <button type="button" class="btn btn-default active dropdown-toggle" data-toggle="dropdown">
            <?=\yii::t('app', '{year} year', ['year' => $checked])?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <?php foreach (range(date('Y'), \yii::$app->params['yearFirst']) as $year): ?>
                <?php if ($checked === $year) continue; ?>
                <li><a href="<?=Url::toRoute([\yii::$app->controller->action->id, 'year' => $year])?>"><?=\yii::t('app', '{year} year', [
                    'year' => $year,
                ])?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <button type="button" class="btn btn-default active" data-toggle="dropdown">
            <?=\yii::t('app', '{year} year', [
                'year' => date('Y'),
            ])?>
        </button>
    <?php endif; ?>
</div>