<?php \yii::app()->getClientScript()->registerCoreScript('ckeditor'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appQaView();
    });
</script>

<h2>
    <?=\CHtml::encode($question->title)?>
    <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_QA_QUESTION_UPDATE, array(
        'question' => $question,
    ))): ?>
        <small><a href="<?=$this->createUrl('ask', array(
            'id' => $question->_id
        ))?>"><?=\yii::t('app', 'Edit')?></a></small>
    <?php endif; ?>
</h2>

<p>
    <em><?php \web\widgets\user\Name::create(array('user' => $question->user)); ?></em>,
    <span class="text-muted"><?=date('Y-m-d H:i:s', $question->dateCreated)?></span>
</p>

<hr />

<div>
    <?=$question->content?>
</div>

<div>
    <?php foreach ($question->tagList as $tag): ?>
        <?php \web\widgets\qa\Tag::create(array('tag' => $tag)); ?>
    <?php endforeach; ?>
</div>

<hr />

<h3 class="qa-answer-count <?=$question->answerCount ? '' : 'hide'?>" style="margin-bottom: 20px;">
    <?=\yii::t('app', '{n} Answer|{n} Answers', $question->answerCount)?>
</h3>

<div class="qa-answer-list">
    <?php foreach ($answers as $answer): ?>
        <?php $this->renderPartial('partial/answer', array(
            'answer' => $answer,
        )); ?>
    <?php endforeach; ?>
</div>

<h3><?=\yii::t('app', 'Your Answer')?></h3>
<input type="hidden" name="questionId" value="<?=$question->_id?>" />
<div class="form-horizontal clearfix">
    <div class="form-group">
        <textarea id="answer-content" name="content"></textarea>
    </div>
</div>
<br/>
<?php if (!\yii::app()->user->isGuest): ?>
    <button type="button" class="btn btn-primary answer-create">
        <?=\yii::t('app', 'Post Your Answer')?>
    </button>
<?php else: ?>
    <a href="<?=$this->createUrl('/auth/login')?>" class="btn btn-primary answer-create">
        <?=\yii::t('app', 'Login')?>
    </a>
<?php endif; ?>
