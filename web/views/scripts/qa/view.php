<?php \yii::app()->getClientScript()->registerCoreScript('ckeditor'); ?>

<a class="btn btn-warning" href="/qa/update/<?=(string)$question->_id?>"><?=\yii::t('app', 'Edit')?></a>

<br/>
<br/>

<div class="panel panel-primary">
    <div class="panel-heading"><?=\CHtml::encode($question->title)?></div>
    <div class="panel-body"><?=$question->content?></div>
    <div class="panel-footer text-muted">
        <div class="row">
            <div class="col-md-6 text-left">
                <?php foreach ($question->tagList as $tag): ?>
                    <?php \web\widgets\qa\Tag::create(array('tag' => $tag)); ?>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6 text-right">
                <em><?php \web\widgets\user\Name::create(array('user' => $question->user)); ?></em>
                &nbsp;
                <span class="text-muted"><?=date('Y-m-d H:i:s', $question->dateCreated)?></span>
            </div>
        </div>
    </div>
</div>

<?php if ($question->answerCount): ?>
    <h3><?=\yii::t('app', '{count} Answers', array('{count}' => $question->answerCount))?></h3>
    <hr/>
    <?php foreach ($answers as $answer): ?>
        <div class="row">
            <div class="col-xs-14 col-md-12">
                <div class="panel <?=$answer->user->isApprovedCoordinator ? 'panel-success' : 'panel-default'?>">
                    <div class="panel-heading"><?php \web\widgets\user\Name::create(array('user' => $question->user)); ?></div>
                    <div class="panel-body"><?=\CHtml::encode($answer->content)?></div>
                    <div class="panel-footer text-muted"><?=date('Y-m-d H:i:s', $answer->dateCreated)?></div>
                </div>
            </div>
        </div>
        <br/>
    <?php endforeach; ?>
<?php else: ?>
    <div class="row">
        <div class="col-xs-14 col-md-12">
            <h4><?=\yii::t('app', 'There isn\'t a single answer')?></h4>
        </div>
    </div>
    <br/>
<?php endif; ?>

<div class="row">
    <div class="col-xs-14 col-md-12 answer-container">
        <div class="form-horizontal clearfix">
            <div class="form-group">
                <textarea id="answer-content" name="content"></textarea>
            </div>
        </div>
        <br/>
        <button type="button" class="btn btn-primary answer-create">
            <?=\yii::t('app', \yii::app()->user->isGuest ? 'Login' : 'Submit')?>
        </button>
    </div>
</div>

<script>
    $(function(){
        window.editor = CKEDITOR.replace('answer-content', {
            extraPlugins: 'onchange',
            height: '200px'
        });

        $(".answer-create").on('click', function(){
            $.ajax({
                type: "POST",
                url: "/qa/saveAnswer/<?=(string)$question->_id?>",
                data: {
                    content: window.editor.getData()
                },
                success: function(data) {
                    if (data.status === 'success') {
                        window.location = "/qa/view/<?=(string)$question->_id?>";
                    } else {
                        appShowErrors(data.errors, $('.form-horizontal'));
                    }
                },
                error: function(xhr) {
                    if (parseInt(xhr.status) === 403) {
                        window.location = "/auth/login";
                    } else {
                        console.log('Unexpected server error: ', xhr.statusText);
                    }
                }
            });
        });
    });
</script>