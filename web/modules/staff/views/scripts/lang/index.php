<?php
    \yii::app()->clientScript->registerCoreScript('jquery.jqgrid');
    $this->pageTitle = \yii::t('app', '{app} - Languages', array('{app}' => \yii::app()->name));
?>

<script type="text/javascript">
    $(document).ready(function(){

        new appStaffLangIndex();

        $('table#message')
            .jqGrid({
                url: '<?=$this->createUrl('getMessageList')?>',
                colNames: <?=\CJSON::encode(array(
                    \yii::t('app', 'Lang'),
                    \yii::t('app', 'Message'),
                    \yii::t('app', 'Translation'),
                ))?>,
                colModel: [
                    {name: 'language', index: 'language', width: 20},
                    {name: 'message', index: 'message', width: 40},
                    {name: 'translation', index: 'translation', width: 40, editable: true},
                ],
                autowidth:   true,
                caption:    '<?=\yii::t('app', 'Message translations')?>',
                cellurl:    '<?=$this->createUrl('saveTranslation')?>',
                sortname:   'language',
                sortorder:  'desc',
                loadError: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            })
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false
            });
    });
</script>

<div class="staff-translate-form-container clearfix">
    <button type="submit" class="btn btn-default pull-left parse" rel="tooltip" title="<?=\yii::t('app', 'Update translation messages')?>">
        <?=\yii::t('app', 'Update')?>
    </button>
</div>
<br />
<table id="message" style="width: 100%;"></table>