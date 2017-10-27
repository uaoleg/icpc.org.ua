<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Json;
use \yii\helpers\Url;

?>

<?= Html::jsFile('https://code.jquery.com/jquery-1.12.4.min.js') ?>
<?= Html::jsFile('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js') ?>
<?= Html::cssFile('@web/lib/jquery-ui-1.10.3/themes/base/minified/jquery-ui.min.css') ?>

<?= Html::cssFile('@web/lib/bootstrap-3.2.0/css/bootstrap.min.css') ?>
<?= Html::jsFile('@web/lib/bootstrap-3.2.0/js/bootstrap.min.js') ?>
<?= Html::jsFile('@web/lib/bootbox-4.2.0/bootbox.min.js') ?>

<?= Html::cssFile('@web/lib/select2/select2.css') ?>
<?= Html::cssFile('@web/lib/select2/select2-bootstrap.css') ?>
<?= Html::jsFile('@web/lib/select2/select2.js') ?>

<?php if (\yii::$app->request->userAgentIsMsie()): ?>
    <?= Html::jsFile('@web/lib/jquery/placeholder/jquery.placeholder.min.js') ?>
    <?= Html::jsFile('@web/lib/respond-1.3.0/respond.min.js') ?>
<?php endif ?>

<?= Html::cssFile('@web/css/app.css?v=' . filemtime(\yii::getAlias('@webroot/css/app.css'))) ?>
<?= Html::jsFile("@web/js/app.js?v=" . filemtime(\yii::getAlias("@webroot/js/app.js"))) ?>

<script type="text/javascript">

    // Application setup
    app = <?=Json::encode(array(
        'language'  => \yii::$app->language,
        'name'      => \yii::$app->name,
        'baseUrl'   => '',
        'themeUrl'  => Url::to('@web'),
        'homeUrl'   => Url::toRoute(['/']),
    ))?>;

    // Ajax setup
    $.ajaxSetup({
        type: 'POST',
        data: {
            <?= \yii::$app->request->csrfParam ?>: '<?= \yii::$app->request->csrfToken ?>'
        }
    });

    $(document).ready(function(){

        // Tooltips
        $('[rel=tooltip]').tooltip();

        // Bootbox confirmation
        bootbox.setDefaults({
            animate: false
        });
        $(document).on('bootboxconfirm', function() {
            $('.btn[data-confirm], a[data-confirm]').on('click', function() {
                var $this = $(this);
                bootbox.confirm($this.data('confirm'), function(confirmed) {
                    if (confirmed) {
                        $this.trigger('confirmed');
                    }
                });
            });
        }).trigger('bootboxconfirm');

        // Disable labels
        $(':disabled').closest('label').addClass('disabled');

        // Placeholder for MSIE
        <?php if (\yii::$app->request->userAgentIsMsie()): ?>
            $('input, textarea').placeholder();
        <?php endif; ?>

    });
</script>