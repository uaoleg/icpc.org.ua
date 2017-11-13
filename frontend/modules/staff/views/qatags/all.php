<?php

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffQatagsIndex();
    });
</script>

<div class="clearfix">
    <h1 class="pull-left">
        <?=\yii::t('app', 'All Tags')?>
    </h1>
    <a href="<?=Url::toRoute(['manage'])?>"
       class="btn btn-success btn-lg pull-right"
       style="margin: 10px 0 0;"><?=\yii::t('app', 'Create Tag')?></a>
</div>

<table class="table table-striped qatags__manage-table">
    <tr>
        <th>
            <?=\yii::t('app', 'Tag Name')?>
        </th>
        <th>
            <?=\yii::t('app', 'Tag Description')?>
        </th>
        <th>
            <?=\yii::t('app', 'Number of questions')?>
        </th>
        <th></th>
    </tr>
    <?php foreach ($tags as $tag): ?>
    <tr class="tag-row">
        <td>
            <?=Html::encode($tag->name)?>
        </td>
        <td>
            <div class="ellipsis">
                <?=Html::encode($tag->desc)?>
            </div>
        </td>
        <td>
            <a href="<?=Url::toRoute(['/qa/latest', 'tag' => $tag->name])?>">
                <?=$tag->questionCount?>
            </a>

        </td>
        <td>
            <a href="<?=Url::toRoute(['manage', 'id' => $tag->id])?>" class="btn btn-primary"><?=\yii::t('app', 'Edit')?></a>
            <button
                data-id="<?=$tag->id?>"
                data-bootbox-confirm="<?=\yii::t('app', 'There {0, plural, one{is # question} few{are # questions} many{are # questions} other{are # questions}} with this tag. Are you sure?', $tag->questionCount)?>"
                class="btn btn-danger btn-delete-tag"
            >
                <?=\yii::t('app', 'Delete')?>
            </button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
