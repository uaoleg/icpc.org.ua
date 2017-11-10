<?php

/* @var $this   \yii\web\View */
/* @var $teams  \common\models\Team[] */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<table width="100%" border="1">
    <thead>
        <tr>
            <th rowspan="2">№</th>
            <th rowspan="2"><?=\yii::t('app', 'University full name (ukrainian and english), team name')?></th>
            <th colspan="2"><?=\yii::t('app', 'Full names of students and coach')?></th>
            <th rowspan="2"><?=\yii::t('app', 'E-mail')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Phone number (mobile, home, work)')?></th>
            <th rowspan="2"><?=\yii::t('app', 'T-shirt size')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Year of birth')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Admission year')?></th>
            <th rowspan="2"><?=\yii::t('app', 'Year')?></th>
        </tr>
        <tr>
            <th><?=\yii::t('app', 'Ukrainian language')?></th>
            <th><?=\yii::t('app', 'English language')?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($teams as $team): ?>
            <tr>
                <td rowspan="4"><?=$i++?></td>
                <td rowspan="4">
                    <p>
                        <?=Html::encode($team->school->fullNameUk)?><br/><br/>
                        <?=Html::encode($team->school->fullNameEn)?><br/><br/>
                        <strong><?=Html::encode($team->name)?></strong>
                    </p>
                </td>
                <?= $this->render('partial/participants/person', array('user'=> $team->members[0]->user)); ?>
            </tr>
            <tr>
                <?= $this->render('partial/participants/person', array('user'=> $team->members[1]->user)); ?>
            </tr>
            <tr>
                <?= $this->render('partial/participants/person', array('user'=> $team->members[2]->user)); ?>
            </tr>
            <tr>
                <?= $this->render('partial/participants/person', array('user'=> $team->coach)); ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
