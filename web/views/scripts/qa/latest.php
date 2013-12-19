<h2><?=\yii::t('app', 'Latest questions')?></h2>

<hr />

<a class="btn btn-primary" href="<?=$this->createUrl('ask')?>"><?=\yii::t('app', 'Ask a question')?></a>

<br />
<br />

<ul class="list-group">
    <?php foreach($questions as $question): ?>
        <li class="list-group-item">
            <div class="row">
                <div class="col-lg-11">
                    <a href="<?=$this->createUrl('view', array(
                        'id' => $question->_id,
                    ))?>"><?=\CHtml::encode($question->title)?></a>
                    &nbsp;
                    <span class="badge"><?=$question->answerCount?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 text-left">
                    <?php foreach ($question->tagList as $tag): ?>
                        <?php \web\widgets\qa\Tag::create(array('tag' => $tag)); ?>
                    <?php endforeach; ?>
                </div>
                <div class="col-lg-6 text-right">
                    <span class="text-muted"><em>
                        <?php \web\widgets\user\Name::create(array('user' => $question->user)) ?>
                    </em></span>
                    &nbsp;
                    <span class="text-muted"><?=date('Y-m-d H:i:s', $question->dateCreated)?></span>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
