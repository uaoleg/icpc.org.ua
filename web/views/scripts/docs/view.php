<script type="text/javascript">
    $(document).ready(function() {
        new appDocsItem();
    });
</script>

<?php \web\widgets\document\Row::create(array(
    'document'              => $document,
    'afterDeleteRedirect'   => $afterDeleteRedirect,
)); ?>