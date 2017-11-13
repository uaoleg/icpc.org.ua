<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<h2><?=\yii::t('app', 'Tag Manage')?></h2>

<hr/>

<div class="form-horizontal clearfix">
    <input type="hidden" name="id" value="<?=$tag->id?>" />
    <div class="form-group">
        <input type="text"
               class="form-control"
               name="name"
               value="<?=Html::encode($tag->name)?>"
               placeholder="<?=\yii::t('app', 'Title')?>">
    </div>
    <div class="form-group">
        <textarea class="form-control"
                  name="desc"
                  id="tag-desc"
                  placeholder="<?=\yii::t('app', 'Description')?>"><?=Html::encode($tag->desc)?></textarea>
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-primary save-tag btn-lg">
            <?=\yii::t('app', 'Save')?>
        </button>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffQatagsManage();
    });
</script>
