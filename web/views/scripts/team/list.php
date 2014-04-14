<?php \yii::app()->getClientScript()->registerCoreScript('jquery.jqgrid'); ?>

<script type="text/javascript">
    $(document).ready(function(){

        var $table = $('#team-list');
        $table.jqGrid({
            url: '<?=$this->createUrl('/team/GetTeamListJson')?>',
            datatype: 'json',
            colNames: <?=\CJSON::encode(array(
                \yii::t('app', 'Team name'),
                \yii::t('app', 'School name'),
                \yii::t('app', 'Coach name'),
                \yii::t('app', 'Members'),
                \yii::t('app', 'State'),
                \yii::t('app', 'Region'),
                \yii::t('app', 'Stage'),
            ))?>,
            colModel: [
                {name: 'name', index: 'name', width: 20, formatter: 'showlink', formatoptions:{baseLinkUrl:'/team/view'}},
                {name: 'schoolName<?=ucfirst($lang)?>', index: 'schoolName<?=ucfirst($lang)?>', width: 20},
                {name: 'coachName<?=ucfirst($lang)?>', index: 'coachName<?=ucfirst($lang)?>', width: 15},
                {name: 'members', index: 'members', width: 40, search: false},
                {name: 'state', index: 'state.<?=\yii::app()->language?>', width: 15, search: true},
                {name: 'region', index: 'region.<?=\yii::app()->language?>', width: 10, search: true},
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
                        $('.btn-csv').data(filters[prop]['field'], filters[prop]['data']);
                    }
                }
            }
        });

        /**
         * Export teams
         */
        $('.btn-csv-checking-system').on('click', function(e){
            e.preventDefault();
            var $btn_csv = $(this).closest('.btn-csv');
            location.href = '<?=$this->createUrl('/team/exportCheckingSystem')?>'
                + '/phase/' + $btn_csv.data('phase')
                + (($btn_csv.data('name')!==undefined) ? ('/name/' + $btn_csv.data('name')) : '')
                + (($btn_csv.data('schoolNameUk')!==undefined) ? ('/schoolNameUk/' + $btn_csv.data('schoolNameUk')) : '')
                + (($btn_csv.data('schoolNameEn')!==undefined) ? ('/schoolNameEn/' + $btn_csv.data('schoolNameEn')) : '')
                + (($btn_csv.data('coachNameUk')!==undefined) ? ('/coachNameUk/' + $btn_csv.data('coachNameUk')) : '')
                + (($btn_csv.data('coachNameEn')!==undefined) ? ('/coachNameEn/' + $btn_csv.data('coachNameEn')) : '')
                + (($btn_csv.data('state.uk')!==undefined) ? ('/state.uk/' + $btn_csv.data('state.uk')) : '')
                + (($btn_csv.data('state.en')!==undefined) ? ('/state.en/' + $btn_csv.data('state.en')) : '')
                + (($btn_csv.data('region.uk')!==undefined) ? ('/region.uk/' + $btn_csv.data('region.uk')) : '')
                + (($btn_csv.data('region.en')!==undefined) ? ('/region.en/' + $btn_csv.data('region.en')) : '');
        });
        $('.btn-csv-registration').on('click', function(e){
            e.preventDefault();
            var $btn_csv = $(this).closest('.btn-csv');
            location.href = '<?=$this->createUrl('/team/exportCheckingSystem')?>'
                + '/phase/' + $btn_csv.data('phase')
                + (($btn_csv.data('name')!==undefined) ? ('/name/' + $btn_csv.data('name')) : '')
                + (($btn_csv.data('schoolNameUk')!==undefined) ? ('/schoolNameUk/' + $btn_csv.data('schoolNameUk')) : '')
                + (($btn_csv.data('schoolNameEn')!==undefined) ? ('/schoolNameEn/' + $btn_csv.data('schoolNameEn')) : '')
                + (($btn_csv.data('coachNameUk')!==undefined) ? ('/coachNameUk/' + $btn_csv.data('coachNameUk')) : '')
                + (($btn_csv.data('coachNameEn')!==undefined) ? ('/coachNameEn/' + $btn_csv.data('coachNameEn')) : '')
                + (($btn_csv.data('state.uk')!==undefined) ? ('/state.uk/' + $btn_csv.data('state.uk')) : '')
                + (($btn_csv.data('state.en')!==undefined) ? ('/state.en/' + $btn_csv.data('state.en')) : '')
                + (($btn_csv.data('region.uk')!==undefined) ? ('/region.uk/' + $btn_csv.data('region.uk')) : '')
                + (($btn_csv.data('region.en')!==undefined) ? ('/region.en/' + $btn_csv.data('region.en')) : '');
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