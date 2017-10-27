<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<div class="clearfix">
    <h1 class="pull-left">
        <?=\yii::t('app', 'Latest Questions')?>
    </h1>
    <a href="<?=Url::toRoute(['ask'])?>"
       class="btn btn-success btn-lg pull-right"
       style="margin: 10px 0 0;"><?=\yii::t('app', 'Ask Question')?></a>
    <?php if (\yii::$app->user->can(\common\components\Rbac::OP_QA_TAG_CREATE)): ?>
    <a href="<?=Url::toRoute(['/staff/qaTags'])?>"
       class="btn btn-default btn-lg pull-right"
       style="margin: 10px 20px 0 0;"><?=\yii::t('app', 'Manage Tags')?></a>
    <?php endif; ?>
</div>

<hr />

<?php foreach($questions as $question): ?>
    <div>
        <h2>
            <div class="ellipsis">
                <a href="<?=Url::toRoute(['view', 'id' => $question->id])?>"><?=Html::encode($question->title)?></a>,
            </div>
            <?=\yii::t('app', '{0, plural, one{# answer} few{# answers} many{# answers} other{# answers}}', $question->answersCount)?>
        </h2>
        <p>
            <span class="text-muted">
                <em>
                    <a href="<?=Url::toRoute(['/user/view', 'id' => $question->user->id])?>">
                        <?=\frontend\widgets\user\Name::widget(array('user' => $question->user))?></a>,
                </em>
            </span>
            <span class="text-muted"><?=date('Y-m-d H:i:s', $question->timeCreated)?></span>
        </p>
        <div>
            <?php foreach ($question->tags as $tag): ?>
                <?=\frontend\widgets\qa\Tag::widget(['tag' => $tag])?>
            <?php endforeach; ?>
        </div>
    </div>
    <hr />
<?php endforeach; ?>

<?php if (count($tags)): ?>
    <div class="row">
        <div class="col-lg-12">
            <h3><?=\yii::t('app', 'Filter questions by following tags')?></h3>
            <?php foreach ($tags as $tag): ?>
                <?=\frontend\widgets\qa\Tag::widget(array('tag' => $tag->name))?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>