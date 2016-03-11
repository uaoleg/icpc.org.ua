<?php
    use \common\models\User;
?>
<?php \yii::app()->clientScript->registerCoreScript('jquery.jqgrid'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        new appStaffCoordinatorsIndex();

        $('#staff__coordinators_list')
            .jqGrid({
                url: '<?=$this->createUrl('/staff/coordinators/GetListJson')?>',
                datatype: 'json',
                colNames: <?=\CJSON::encode(array_merge(array(
                    \yii::t('app', 'Name'),
                    \yii::t('app', 'Email'),
                    \yii::t('app', 'Registration date'),
                    \yii::t('app', 'Status'),
                )))?>,
                colModel: [
                    {name: 'name', index: 'name', width: 150, sortable: false, search: false, formatter: 'showlink', formatoptions: {baseLinkUrl: '/user/view'}},
                    {name: 'email', index: 'email', width: 150},
                    {name: 'dateCreated', index: 'dateCreated', width: 50, formatter: 'date', formatoptions: {newformat: 'Y-m-d'}, search: false},
                    {name: 'isApprovedCoordinator', index: 'isApprovedCoordinator', align: 'center', width: 50, search: true, sortable: false, stype: 'select', searchoptions: {sopt: ['bool'], value: "-1:<?=\yii::t('app', 'All')?>;0:<?=\yii::t('app', 'Suspended')?>;1:<?=\yii::t('app', 'Active')?>"}},
                ],
                sortname: 'dateCreated',
                sortorder: 'desc'
            })
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false
            });
            $('.confirmation').on('click', function () {
                return confirm('Are you really want to Deactivate all Coordinators?');
            });
    });
</script>

<h3><?=\yii::t('app', 'List of Coordinators')?></h3>
<div class="btn-group"><a href="/staff/coordinators/deactivateAll" class="btn btn-danger confirmation"><?=\yii::t('app', 'Disactivate all Coordinators')?></a></div>
<table id="staff__coordinators_list" style="width: 100%;"></table>