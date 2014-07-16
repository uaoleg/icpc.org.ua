<?php
    use \common\models\User;
?>
<?php \yii::app()->clientScript->registerCoreScript('jquery.jqgrid'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffStudentsIndex();

        $('#staff__students_list')
            .jqGrid({
                url: '<?=$this->createUrl('/staff/students/GetListJson')?>',
                datatype: 'json',
                colNames: <?=\CJSON::encode(array_merge(array(
                    \yii::t('app', 'Name'),
                    \yii::t('app', 'Email'),
                    \yii::t('app', 'Registration date'),
                    \yii::t('app', 'Status'),
                )))?>,
                colModel: [
                    {name: 'name', index: 'name', width: 150, sortable: false, search: false, formatter: 'showlink', formatoptions:{baseLinkUrl:'/user/view'}},
                    {name: 'email', index: 'email', width: 150},
                    {name: 'dateCreated', index: 'dateCreated', width: 50, formatter: 'date', formatoptions: {newformat: 'Y-m-d'}, search: false},
                    {name: 'isApprovedStudent', index: 'isApprovedStudent', align: 'center', width: 50, search: true, sortable: false, stype: 'select', searchoptions: {sopt: ['bool'], value: "-1:<?=\yii::t('app', 'All')?>;0:<?=\yii::t('app', 'Suspended')?>;1:<?=\yii::t('app', 'Active')?>"}},
                ],
                sortname: 'dateCreated',
                sortorder: 'desc'
            })
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false
            });

    });
</script>

<h3><?=\yii::t('app', 'List of Students')?></h3>
<table id="staff__students_list" style="width: 100%;"></table>