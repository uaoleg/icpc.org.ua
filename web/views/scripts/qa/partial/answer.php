<div class="qa-answer">
    <div>
        <?=$answer->content?>
    </div>
    <div class="clearfix">
        <div class="pull-right">
            <a href="<?=$this->createUrl('/user/view', array('id' => $answer->user->_id))?>">
                <?php \web\widgets\user\Name::create(array('user' => $answer->user)); ?></a>
            <br />
            <span class="text-muted"><?=date('Y-m-d H:i:s', $answer->dateCreated)?></span>
        </div>
    </div>
    <hr />
</div>
