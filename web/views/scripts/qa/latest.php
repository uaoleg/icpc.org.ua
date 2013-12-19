<div class="clearfix">
    <h1 class="pull-left">
        <?=\yii::t('app', 'Latest Questions')?>
    </h1>
    <a href="<?=$this->createUrl('ask')?>"
       class="btn btn-success btn-lg pull-right"
       style="margin-top: 10px;"><?=\yii::t('app', 'Ask Question')?></a>
</div>

<hr />

<?php foreach($questions as $question): ?>
    <div>
        <h2>
            <a href="<?=$this->createUrl('view', array(
                'id' => $question->_id,
            ))?>"><?=\CHtml::encode($question->title)?></a>,
            <?=\yii::t('app', '{n} answer|{n} answers', $question->answerCount)?>
        </h2>
        <p>
            <span class="text-muted"><em>
                <?php \web\widgets\user\Name::create(array('user' => $question->user)) ?>,
            </em></span>
            <span class="text-muted"><?=date('Y-m-d H:i:s', $question->dateCreated)?></span>
        </p>
        <div>
            <?php foreach ($question->tagList as $tag): ?>
                <?php \web\widgets\qa\Tag::create(array('tag' => $tag)); ?>
            <?php endforeach; ?>
        </div>
    </div>
    <hr />
<?php endforeach; ?>
