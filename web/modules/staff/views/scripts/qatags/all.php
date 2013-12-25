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
    </tr>
    <?php foreach ($tags as $tag): ?>
    <tr>
        <td>
            <?=$tag->name?>
        </td>
        <td>
            <?=$tag->desc?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
