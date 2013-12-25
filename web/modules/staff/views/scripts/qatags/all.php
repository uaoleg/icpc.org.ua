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


<script>
    $(function(){
        $('.tag').on('click', function(){
            var $el = $(this);
            if (confirm('<?php echo \yii::t('app', 'Are you sure you want to delete this tag: "'); ?>' + $el.data('name') + '" ?')) {
                $.ajax({
                    type: "POST",
                    url: "/staff/tags/delete/" + $el.data('id'),
                    success: function(data) {
                        if (data.result) {
                            $el.remove();
                        }
                    },
                    error: function(xhr) {
                        if (parseInt(xhr.status) === 403) {
                            alert('<?php echo \yii::t('app', 'You are forbidden to perform this action'); ?>');
                        } else {
                            console.log('Unexpected server error: ', xhr.statusText);
                        }
                    }
                });
            }
            return false;
        });
    });
</script>