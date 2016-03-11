<?php \yii::app()->clientScript->registerCoreScript('jquery.jqgrid'); ?>
<?php
    $stateSelects = array(':' . \yii::t('app', 'All'));
    foreach ($states as $index => $state) {
        $stateSelects[] = "{$index}:{$state}";
    }
    $stateSelects = implode(';', $stateSelects);
?>
<script type="text/javascript">
    $(document).ready(function() {
        new appStaffCoachesIndex();

        $('#staff__coaches_list')
            .jqGrid({
                url: '<?=$this->createUrl('/staff/coaches/GetListJson')?>',
                datatype: 'json',
                colNames: <?=\CJSON::encode(array_merge(array(
                    \yii::t('app', 'Name'),
                    \yii::t('app', 'Email'),
                    \yii::t('app', 'State'),
                    \yii::t('app', 'Registration date'),
                    \yii::t('app', 'Status'),
                )))?>,
                colModel: [
                    {name: 'name', index: 'name', width: 150, sortable: false, search: false, formatter: 'showlink', formatoptions: {baseLinkUrl: '/user/view'}},
                    {name: 'email', index: 'email', width: 150},
                    {name: 'state', index: 'state', align: 'center', width: 50, search: true, sortable: false, stype: 'select', searchoptions: {sopt: ['string'], value: "<?=$stateSelects;?>"}},
                    {name: 'dateCreated', index: 'dateCreated', width: 50, formatter: 'date', formatoptions: {newformat: 'Y-m-d'}, search: false},
                    {name: 'isApprovedCoach', index: 'isApprovedCoach', align: 'center', width: 50, search: true, sortable: false, stype: 'select', searchoptions: {sopt: ['bool'], value: "-1:<?=\yii::t('app', 'All')?>;0:<?=\yii::t('app', 'Suspended')?>;1:<?=\yii::t('app', 'Active')?>"}},
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

<h3><?=\yii::t('app', 'List of Coaches')?></h3>
<div class="btn-group">
  <button type="button" class="btn btn-danger" id="deactivateAllCoachesModal-modal" data-toggle="modal" data-target="#deactivateAllCoachesModal">
      <?=\yii::t('app', 'Disactivate all Coaches')?>
  </button>
</div>
<div class="modal" id="deactivateAllCoachesModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?=\yii::t('app', 'Disactivate all Coaches')?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" id="uploadContainer">
                        <div class="form-group">
                            <p class="form-control-static">
                              <?=\yii::t('app', 'Are you really want to Deactivate all Coaches?')?>
                            </p>
                        </div>

                        <div class="form-group">
                            <a href="/staff/coaches/deactivateAll" class="btn btn-danger confirmation"><?=\yii::t('app', 'Disactivate all Coaches')?></a>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?=\yii::t('app', 'Close')?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<table id="staff__coaches_list" style="width: 100%;"></table>