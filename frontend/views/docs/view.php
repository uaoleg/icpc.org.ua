<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<script type="text/javascript">
    $(document).ready(function() {
        new appDocsItem();
    });
</script>

<?=\frontend\widgets\document\Row::widget(array(
    'document'              => $document,
    'afterDeleteRedirect'   => $afterDeleteRedirect,
))?>