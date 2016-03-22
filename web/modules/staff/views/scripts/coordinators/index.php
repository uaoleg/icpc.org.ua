<?php

    use \common\models\User;

    \yii::app()->clientScript->registerCoreScript('jquery.jqgrid');

?>

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
    });
</script>

<h3><?=\yii::t('app', 'List of Coordinators')?></h3>

<?php if (\yii::app()->user->checkAccess(User::ROLE_COORDINATOR_UKRAINE, array('user' => \yii::app()->user->getInstance()))): ?>
<div class="btn-group">
    <button type="button" class="btn btn-danger" id="deactivateAllCoordinatorsModal-modal" data-toggle="modal" data-target="#deactivateAllCoordinatorsModal">
        <?=\yii::t('app', 'Deactivate all coordinators')?>
    </button>
</div>
<?php endif; ?>

<br><br>

<table id="staff__coordinators_list" style="width: 100%;"></table>

<?php if (\yii::app()->user->checkAccess(User::ROLE_COORDINATOR_UKRAINE, array('user' => \yii::app()->user->getInstance()))): ?>
<div class="modal" id="deactivateAllCoordinatorsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?=\yii::t('app', 'Deactivate all coordinators')?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" id="uploadContainer">
                        <div class="form-group">
                            <p class="form-control-static">
                              <?=\yii::t('app', 'Are you really want to deactivate all coordinators?')?>
                            </p>
                        </div>

                        <div class="form-group">
                            <a href="<?=$this->createUrl('/staff/coordinators/deactivateAll')?>" class="btn btn-danger confirmation">
                                <?=\yii::t('app', 'Deactivate all coordinators')?>
                            </a>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?=\yii::t('app', 'Cancel')?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
