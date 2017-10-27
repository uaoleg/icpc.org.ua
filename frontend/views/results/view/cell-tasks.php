<?php

/* @var $this   \yii\web\View */
/* @var $result \common\models\Result */

use \common\models\Result;
use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div
    style="cursor: pointer;"
    data-toggle="popover"
    data-trigger="hover"
    data-placement="left"
    >
    <span class="glyphicon glyphicon-stats"></span>
    <div class="js-content hidden">
        <table class="table">
            <tr>
                <th></th>
                <th><?= \yii::t('app', 'Tries') ?></th>
                <th><?= \yii::t('app', 'Time') ?></th>
            </tr>
            <?php foreach ($result->tasks as $task): ?>
            <tr>
                <th><?= $task->letter ?></th>
                <td class="text-center">
                    <?= $task->triesCount ?>
                </td>
                <td class="text-center">
                    <?php
                        if ($task->triesCount > 0) {
                            $datetime = new \DateTime();
                            $datetime->setTime(0, 0, $task->secondsSpent);
                            $time = $datetime->format('G:i');
                        } else {
                            $time = '&mdash;';
                        }
                    ?>
                    <?= $time ?>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
