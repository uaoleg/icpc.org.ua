<div class="qa-answer">
    <div>
        <?=$answer->content?>
    </div>
    <div class="clearfix">
        <div class="pull-right">
            <?php \web\widgets\user\Name::create(array('user' => $answer->user)); ?>
            <br />
            <span class="text-muted"><?=date('Y-m-d H:i:s', $answer->dateCreated)?></span>
        </div>
    </div>
    <hr />
</div>
