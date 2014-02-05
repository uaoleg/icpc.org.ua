<?php \yii::app()->getClientScript()->registerCoreScript('jquery.jqgrid'); ?>

<script type="text/javascript">
    $(document).ready(function(){

        var $table = $('#team-list');
        $table.jqGrid({
            url: '<?=$this->createUrl('/team/GetTeamListJson')?>',
            datatype: 'json',
            colNames: [
                '<?=\yii::t('app', 'Team name')?>',
                '<?=\yii::t('app', 'School name')?>',
                '<?=\yii::t('app', 'Coach name')?>',
                '<?=\yii::t('app', 'Members')?>',
                '<?=\yii::t('app', 'State')?>',
                '<?=\yii::t('app', 'Region')?>',
                '<?=\yii::t('app', 'Stage')?>'
            ],
            colModel: [
                {name: 'name', index: 'name', width: 20, formatter: 'showlink', formatoptions:{baseLinkUrl:'/team/view'}},
                {name: 'schoolName<?=ucfirst(\yii::app()->language)?>', index: 'schoolName<?=ucfirst(\yii::app()->language)?>', width: 20},
                {name: 'coachName<?=ucfirst(\yii::app()->language)?>', index: 'coachName<?=ucfirst(\yii::app()->language)?>', width: 15},
                {name: 'members', index: 'members', width: 40, search: false},
                {name: 'state', index: 'state', width: 15, search: false},
                {name: 'region', index: 'region', width: 10, search: false},
                {name: 'phase', index: 'phase', width: 5, stype: 'select', searchoptions: {sopt: ['ge'], value: "1:1;2:2;3:3"}}
            ],
            sortname: 'teamname',
            sortorder: 'asc',
            autowidth: true,
            beforeSelectRow: function() {
                return false;
            }
        });
        $table.jqGrid('filterToolbar', {
            stringResult: true,
            searchOnEnter: false,
            afterSearch: function() {
                var filters = JSON.parse($table.getGridParam("postData").filters).rules;
                for(var prop in filters) {
                    if (filters.hasOwnProperty(prop)) {
                        if (filters[prop]['field'] === 'phase') {
                            $('.btn-csv').data('phase', filters[prop]['data']);
                        }
                    }
                }
            }
        });

        /**
         * Export teams
         */
        $('.btn-csv-checking-system').on('click', function(e){
            e.preventDefault();
            location.href = '<?=$this->createUrl('/team/exportCheckingSystem')?>' + '/phase/' + $(this).closest('.btn-csv').data('phase');
        });
        $('.btn-csv-registration').on('click', function(e){
            e.preventDefault();
            location.href = '<?=$this->createUrl('/team/exportRegistration')?>' + '/phase/' + $(this).closest('.btn-csv').data('phase');
        });
    });
</script>

<div class="clearfix">

    <div class="pull-right">
        <?php \web\widgets\filter\Year::create(array('checked' => $year)); ?>
    </div>

    <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_TEAM_CREATE)): ?>
        <a class="btn btn-success btn-lg" href="<?=$this->createUrl('/staff/team/manage')?>">
            <?=\yii::t('app', 'Create a new team')?>
        </a>
    <?php endif; ?>

    <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_TEAM_EXPORT)): ?>
        <div class="btn-group btn-csv" data-phase="1">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?=\yii::t('app', 'Export to CSV')?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#" class="btn-csv-checking-system"><?=\yii::t('app', 'For checking system')?></a></li>
                <li><a href="#" class="btn-csv-registration"><?=\yii::t('app', 'For registration')?></a></li>
            </ul>
        </div>
    <?php endif; ?>

</div>

<hr />

<?php if ($teamsCount > 0): ?>

    <table id="team-list" style="width: 100%;"></table>

<?php else: ?>

    <div class="alert alert-info">
        <?=\yii::t('app', 'There are no teams.')?>
    </div>

<?php endif; ?>