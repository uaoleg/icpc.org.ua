<?php
    \yii::app()->clientScript->registerCoreScript('jquery.jqgrid');
    $this->pageTitle = \yii::t('app', 'Organizations');
?>

<script type="text/javascript">
    $(document).ready(function(){

        new appStaffLangIndex();

        $('table#organizations')
            .jqGrid({
                url: '<?=$this->createUrl('getList')?>',
                colNames: <?=\CJSON::encode(array(
                    \yii::t('app', 'Full name (uk)'),
                    \yii::t('app', 'Short name (uk)'),
                    \yii::t('app', 'Full name (en)'),
                    \yii::t('app', 'Short name (en)'),
                    \yii::t('app', 'Type'),
                    \yii::t('app', 'State'),
                ))?>,
                colModel: [
                    {name: 'fullNameUk', index: 'fullNameUk', width: 20, editable: true},
                    {name: 'shortNameUk', index: 'shortNameUk', width: 5, editable: true},
                    {name: 'fullNameEn', index: 'fullNameEn', width: 20, editable: true},
                    {name: 'shortNameEn', index: 'shortNameEn', width: 5, editable: true},
                    {name: 'type', index: 'type', width: 10, editable: true,
                        cellEdit: true,
                        edittype: 'select',
                        editoptions: {value: function() {
                                return <?= json_encode($types) ?>;
                        }},
                        stype: 'select',
                        searchoptions: {sopt: ['bw'], value: "<?= implode(';', $typesForSearch) ?>"}
                    },
                    {name: 'state', index: 'state', width: 10, editable: false, search: false, sortable: false},
                ],
                autowidth:   true,
                caption:    '<?=\yii::t('app', 'Organizations')?>',
                cellurl:    '<?=$this->createUrl('save')?>',
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

<table id="organizations" style="width: 100%;"></table>
