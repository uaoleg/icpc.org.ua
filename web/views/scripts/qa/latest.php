<div class="clearfix">
    <h1 class="pull-left">
        <?=\yii::t('app', 'Latest Questions')?>
    </h1>
    <a href="<?=$this->createUrl('ask')?>"
       class="btn btn-success btn-lg pull-right"
       style="margin: 10px 0 0;"><?=\yii::t('app', 'Ask Question')?></a>
    <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_QA_TAG_CREATE)): ?>
    <a href="<?=$this->createUrl('/staff/qaTags')?>"
       class="btn btn-default btn-lg pull-right"
       style="margin: 10px 20px 0 0;"><?=\yii::t('app', 'Manage Tags')?></a>
    <?php endif; ?>
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
            <span class="text-muted">
                <em>
                    <a href="<?=$this->createUrl('/user/view', array('id' => $question->user->_id))?>">
                        <?php \web\widgets\user\Name::create(array('user' => $question->user)) ?></a>,
                </em>
            </span>
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

<?php if (count($tags)): ?>
    <div class="row">
        <div class="col-lg-12">
            <h3><?=\yii::t('app', 'Filter questions by following tags')?></h3>
            <?php foreach ($tags as $tag): ?>
                <?php \web\widgets\qa\Tag::create(array('tag' => $tag->name));?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>