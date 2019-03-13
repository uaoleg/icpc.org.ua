<?php \yii::app()->getClientScript()->registerCoreScript('jquery.jqgrid'); ?>

<script type="text/javascript">
    $(document).ready(function(){

        // Custom formatter for jqGrid
        function coachShowLink(cellvalue, options, rowObject) {
            if (cellvalue !== null) {
                return '<a href="<?=$this->createUrl('/user/view', array('id' => ''))?>/' + rowObject.coachId + '">' + cellvalue + '</a>'
            } else {
                return '';
            }
        }

        var $table = $('#team-list');
        $table.jqGrid({
            url: '<?=$this->createUrl('getTeamListJson')?>',
            datatype: 'json',
            colNames: <?=\CJSON::encode(array(
                \yii::t('app', 'Team name'),
                \yii::t('app', 'School name'),
                \yii::t('app', 'School type'),
                \yii::t('app', 'Coach name'),
                \yii::t('app', 'Members'),
                \yii::t('app', 'State'),
                \yii::t('app', 'Region'),
                \yii::t('app', 'Status'),
                \yii::t('app', 'Stage'),
            ))?>,
            colModel: [
                {name: 'name', index: 'name', width: 10, formatter: 'showlink', formatoptions:{baseLinkUrl:'/team/view'}},
                {name: 'schoolName<?=ucfirst($lang)?>', index: 'schoolName<?=ucfirst($lang)?>', width: 15},
                {name: 'schoolType', index: 'schoolType', width: 10,
                    stype: 'select',
                    searchoptions: {sopt: ['bw'], value: "<?= implode(';', $schoolTypes) ?>"}
                },
                {name: 'coachName<?=ucfirst($lang)?>', index: 'coachName<?=ucfirst($lang)?>', width: 15, formatter: coachShowLink},
                {name: 'members', index: 'members', width: 30, search: false},
                {name: 'state', index: 'state.<?=\yii::app()->language?>', width: 10, search: true},
                {name: 'region', index: 'region.<?=\yii::app()->language?>', width: 10, search: true},
                {name: 'isOutOfCompetition', index: 'isOutOfCompetition', width: 5, stype: 'select', searchoptions: {sopt: ['bool'], value: "-1:<?=\yii::t('app', 'All')?>;0:<?=\yii::t('app', 'In competition')?>;1:<?=\yii::t('app', 'Out of competition')?>"}},
                {name: 'phase', index: 'phase', width: 5, stype: 'select', searchoptions: {sopt: ['ge'], value: "1:1;2:2;3:3"}}
            ],
            sortname: 'teamname',
            sortorder: 'asc',
            autowidth: true,
            shrinkToFit: true,
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

    });
</script>

<table class="page-top-controls"><tr>

    <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_TEAM_CREATE)): ?>
<!--    <td>-->
<!--        <a class="btn btn-success btn-lg"-->
<!--           href="--><?//=$this->createUrl('/staff/team/manage')?><!--"-->
<!--           title="--><?//=\yii::t('app', 'Create a new team out of competition')?><!--"-->
<!--           rel="tooltip">-->
<!--            <span class="glyphicon glyphicon-plus"></span>-->
<!--            --><?//=\yii::t('app', 'New team')?>
<!--        </a>-->
<!--    </td>-->
    <td>
        <a class="btn btn-success btn-lg"
           href="<?=$this->createUrl('/staff/team/import')?>"
           title="<?=\yii::t('app', 'Import teams from icpc.baylor.edu')?>"
           rel="tooltip">
            <span class="glyphicon glyphicon-cloud-download"></span>
            <?=\yii::t('app', 'Import teams')?>
        </a>
    </td>
    <?php endif; ?>

    <?php if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_TEAM_EXPORT_ALL)): ?>
    <td>
        <div class="btn-group btn-csv" data-phase="1">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?=\yii::t('app', 'Export to CSV')?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?=$this->createUrl('/team/exportCheckingSystem')?>"><?=\yii::t('app', 'For checking system')?></a></li>
                <li><a href="<?=$this->createUrl('/team/exportRegistration')?>"><?=\yii::t('app', 'For registration')?></a></li>
            </ul>
        </div>
    </td>
    <?php endif; ?>

    <td>
        <?php \web\widgets\filter\Year::create(array('checked' => $year)); ?>
    </td>

</tr></table>

<hr />

<?php if ($teamsCount > 0): ?>

    <table id="team-list" style="width: 100%;"></table>

<?php else: ?>

    <div class="alert alert-info">
        <?=\yii::t('app', 'There are no teams.')?>
    </div>

<?php endif; ?>