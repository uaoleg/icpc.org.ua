<script type="text/javascript">
    app = <?=\CJSON::encode(array(
        'language'  => \yii::app()->language,
        'name'      => \yii::app()->name,
        'baseUrl'   => \yii::app()->baseUrl,
        'themeUrl'  => \yii::app()->theme->baseUrl,
        'homeUrl'   => \yii::app()->homeUrl,
    ))?>;

    $(document).ready(function(){
        $('[rel=tooltip]').tooltip();
        $('input, textarea').placeholder();
        $(':disabled').closest('label').addClass('disabled');
    });
</script>