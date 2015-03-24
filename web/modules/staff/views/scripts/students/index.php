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
                    \yii::t('app', 'School'),
                    \yii::t('app', 'Speciality'),
                    \yii::t('app', 'Group'),
                    \yii::t('app', 'Email'),
                    \yii::t('app', 'Phone'),
                    \yii::t('app', 'Course'),
                    \yii::t('app', 'Date of birth'),
                    \yii::t('app', 'Registration date'),
                    \yii::t('app', 'Status'),
                )))?>,
                colModel: [
                    {name: 'name', index: 'name', width: 75, sortable: false, search: false, formatter: 'showlink', formatoptions: {baseLinkUrl: '/user/view'}},
                    {name: 'school', index: 'school', width: 75},
                    {name: 'speciality', index: 'speciality', width: 50},
                    {name: 'group', index: 'group', width: 50},
                    {name: 'email', index: 'email', width: 75},
                    {name: 'phone', index: 'phone', width: 50},
                    {name: 'course', index: 'course', width: 25},
                    {name: 'dateBirthday', index: 'dateBirthday', width: 25, formatter: 'date', formatoptions: {newformat: 'Y-m-d'}, search: false},
                    {name: 'dateCreated', index: 'dateCreated', width: 25, formatter: 'date', formatoptions: {newformat: 'Y-m-d'}, search: false},
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

<h3>
    <?=\yii::t('app', 'List of Students')?>
    <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_USER_EXPORT)): ?>
        <div class="btn-group btn-csv" data-phase="1">
            <a class="btn btn-default" role="button" href="<?=$this->createUrl('/staff/students/export')?>"> <?=\yii::t('app', 'Export to CSV')?></a>
        </div>
    <?php endif; ?>
</h3>

<table id="staff__students_list" style="width: 100%;"></table>