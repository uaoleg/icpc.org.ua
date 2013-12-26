<script type="text/javascript">
    $(document).ready(function() {
        new appStaffQatagsIndex();
    });
</script>

<div class="clearfix">
    <h1 class="pull-left">
        <?=\yii::t('app', 'All Tags')?>
    </h1>
    <a href="<?=$this->createUrl('manage')?>"
       class="btn btn-success btn-lg pull-right"
       style="margin: 10px 0 0;"><?=\yii::t('app', 'Create Tag')?></a>
</div>

<table class="table table-striped">
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
            <?=$tag->name?>
        </td>
        <td>
            <?=$tag->desc?>
        </td>
        <td>
            <a href="<?=$this->createUrl('/qa/latest', array('tag' => $tag->name))?>">
                <?=$tag->questionCount?>
            </a>

        </td>
        <td>
            <a href="<?=$this->createUrl('manage', array('id' => $tag->_id))?>" class="btn btn-primary"><?=\yii::t('app', 'Edit')?></a>
            <button data-id="<?=$tag->_id?>" data-confirm="<?=\yii::t('app', 'There are {n} question(s) with this tag. Are you sure?', array('{n}' => $tag->questionCount))?>" class="btn btn-danger btn-delete-tag">
                <?=\yii::t('app', 'Delete')?>
            </button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
