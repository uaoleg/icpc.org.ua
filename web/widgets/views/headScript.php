<script type="text/javascript">
    app = <?=\CJSON::encode(array(
        'language'  => \yii::app()->language,
        'name'      => \yii::app()->name,
        'baseUrl'   => \yii::app()->baseUrl,
        'themeUrl'  => \yii::app()->theme->baseUrl,
        'homeUrl'   => \yii::app()->homeUrl,
    ))?>;

    $(document).ready(function(){

        // Tooltips
        $('[rel=tooltip]').tooltip();

        // Bootbox confirmation
        bootbox.setDefaults({
            animate: false
        });
        $('.btn[data-confirm]').on('click', function() {
            var $this = $(this);
            bootbox.confirm($this.data('confirm'), function(confirmed) {
                if (confirmed) {
                    $this.trigger('confirmed');
                }
            });
        });

        // Disable labels
        $(':disabled').closest('label').addClass('disabled');

        // Placeholder for MSIE
        <?php if (\yii::app()->request->userAgentIsMsie()): ?>
            $('input, textarea').placeholder();
        <?php endif; ?>

    });
</script>