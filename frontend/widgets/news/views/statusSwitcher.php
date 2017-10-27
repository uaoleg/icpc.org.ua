<?php

/* @var $this       \yii\web\View */
/* @var $news       \common\models\News */
/* @var $btnSize    string */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.news-status-switcher').staffNewsStatusSwitcher();
    });
</script>

<div class="news-status-switcher" data-news-id="<?=$news->commonId?>">
    <button type="button" class="btn btn-success <?=$btnSize?> <?=$news->isPublished ? 'hide' : ''?>"
            <?=$news->isNewRecord ? 'disabled' : ''?>
            data-status="1">
        <?=\yii::t('app', 'Publish')?>
    </button>
    <button type="button" class="btn btn-danger <?=$btnSize?> <?=$news->isPublished ? '' : 'hide'?>"
            <?=$news->isNewRecord ? 'disabled' : ''?>
            data-status="0">
        <?=\yii::t('app', 'Hide')?>
    </button>
</div>