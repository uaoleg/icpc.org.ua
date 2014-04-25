<?php
    use \common\components\Rbac;
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
                    {name: 'name', index: 'name', width: 150, sortable: false, search: false},
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




<table class="table table-row-middle hide">
    <thead>
        <tr>
            <th><?=\yii::t('app', 'Name')?></th>
            <th><?=\yii::t('app', 'Email')?></th>
            <th><?=\yii::t('app', 'Registration date')?></th>
            <th><?=\yii::t('app', 'Action')?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userList as $user): ?>
            <tr data-id="<?=$user->_id?>">
                <td>
                    <a href="<?=$this->createUrl('/user/view', array('id' => (string)$user->_id))?>">
                        <?php \web\widgets\user\Name::create(array('user' => $user)); ?>
                    </a>
                </td>
                <td><?=$user->email?></td>
                <td><?=date('Y-m-d H:i:s', $user->dateCreated)?></td>
                <td>
                    <button type="button" class="btn btn-success student-state <?=$user->isApprovedStudent ? 'hide' : ''?>"
                            <?=(\yii::app()->user->checkAccess(Rbac::OP_STUDENT_SET_STATUS)) ? '' : 'disabled'?>
                            data-state="1">
                        <?=\yii::t('app', 'Activate')?>
                    </button>
                    <button type="button" class="btn btn-danger student-state <?=$user->isApprovedStudent ? '' : 'hide'?>"
                            <?=(\yii::app()->user->checkAccess(Rbac::OP_STUDENT_SET_STATUS)) ? '' : 'disabled'?>
                            data-state="0">
                        <?=\yii::t('app', 'Suspend')?>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>