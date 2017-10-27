<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

$this->title = \frontend\widgets\user\Name::widget(array('user' => $user));

?>

<div class="row">
    <div class="col-lg-2">
        <?=\frontend\widgets\user\Photo::widget(array('photo' => $user->photo))?>
    </div>
    <div class="col-lg-8">
        <h3>
            <?=\frontend\widgets\user\Name::widget(array('user' => $user))?>
        </h3>
        <h4>
            <?php if (isset($user->school->{'fullName' . ucfirst(\yii::$app->language)})): ?>
                <?=$user->school->{'fullName' . ucfirst(\yii::$app->language)}?>
            <?php else: ?>
                <?=$user->school->fullNameUk?>
            <?php endif; ?>
        </h4>

        <?php if (\yii::$app->user->can(\common\components\Rbac::OP_USER_READ_EMAIL)): ?>
            <b><?=$user->getAttributeLabel('email')?></b>:&nbsp;<?=\frontend\widgets\Mailto::widget(array('email' => $user->email))?>
            <br/><br/>
        <?php endif; ?>

        <?php if (count($fullViewAttrs) > 0): ?>
            <div class="row">
                <div class="col-lg-12">
                    <?php foreach ($fullViewAttrs as $attrName => $attrValue): ?>
                        <b><?=$user->info->getAttributeLabel($attrName)?></b>:&nbsp;<?=($attrName!=='dateOfBirth') ? $attrValue : (is_int($attrValue) ? date('Y-m-d', $attrValue) : '')?>
                        <br /><br />
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (count($teams) > 0): ?>
        <div class="row">
            <div class="col-lg-6">
                <h4><?=\yii::t('app', 'Teams')?></h4>
                <div class="list-group">
                    <?php foreach ($teams as $team): ?>
                        <a href="<?=Url::toRoute(['/team/view', 'id' => $team->id])?>" class="list-group-item">
                            <?=$team->name?>&nbsp;<span class="badge"><?=$team->year?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>