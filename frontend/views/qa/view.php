<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

$this->title = $question->title;

$this->registerJsFile('@web/lib/ckeditor-4.2/ckeditor.js', ['position' => \yii\web\View::POS_HEAD]);

?>

<script type="text/javascript">
    $(document).ready(function() {
        new appQaView();
    });
</script>

<h2>
    <div class="break-word">
        <?= Html::encode($question->title) ?>
    </div>
    <?php if (\yii::$app->user->can(\common\components\Rbac::OP_QA_QUESTION_UPDATE, array(
        'question' => $question,
    ))): ?>
        <small><a href="<?=Url::toRoute(['ask', 'id' => $question->id])?>"><?=\yii::t('app', 'Edit')?></a></small>
    <?php endif; ?>
</h2>

<p>
    <em>
        <a href="<?=Url::toRoute(['/user/view', 'id' => $question->user->id])?>">
            <?=\frontend\widgets\user\Name::widget(array('user' => $question->user))?></a>,
    </em>
    <span class="text-muted"><?=date('Y-m-d H:i:s', $question->timeCreated)?></span>
</p>

<hr />

<div class="break-word">
    <?=$question->content?>
</div>

<div>
    <?php foreach ($question->tags as $tag): ?>
        <?=\frontend\widgets\qa\Tag::widget(['tag' => $tag])?>
    <?php endforeach; ?>
</div>

<hr />

<h3 class="qa-answer-count <?=$question->answersCount ? '' : 'hide'?>" style="margin-bottom: 20px;">
    <?=\yii::t('app', '{0, plural, one{# Answer} few{# Answers} many{# Answers} other{# Answers}}', $question->answersCount)?>
</h3>

<div class="qa-answer-list">
    <?php foreach ($answers as $answer): ?>
        <?= $this->render('partial/answer', array(
            'answer' => $answer,
        )); ?>
    <?php endforeach; ?>
</div>

<h3><?=\yii::t('app', 'Your Answer')?></h3>
<input type="hidden" name="questionId" value="<?=$question->id?>" />
<div class="form-horizontal clearfix">
    <div class="form-group">
        <textarea id="answer-content" name="content"></textarea>
    </div>
</div>
<br/>
<?php if (!\yii::$app->user->isGuest): ?>
    <button type="button" class="btn btn-primary answer-create">
        <?=\yii::t('app', 'Post Your Answer')?>
    </button>
<?php else: ?>
    <a href="<?=Url::toRoute(['/auth/login'])?>" class="btn btn-primary answer-create">
        <?=\yii::t('app', 'Login')?>
    </a>
<?php endif; ?>
