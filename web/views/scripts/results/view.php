<?php
    \yii::app()->clientScript->registerCoreScript('jquery.jqgrid');
?>

<script type="text/javascript">
    $(document).ready(function(){

        new appResultsView();

        // Custom formatter for jqGrid
        function coachShowLink(cellvalue, options, rowObject) {
            if (cellvalue !== null) {
                return '<a href="<?=$this->createUrl('/user/view', array('id' => ''))?>/' + rowObject.coachId + '">' + cellvalue + '</a>'
            } else {
                return '';
            }
        }

        $('#results')
            .jqGrid({
                url: '<?=$this->createUrl('/results/GetResultsListJson')?>',
                datatype: 'json',
                colNames: <?=\CJSON::encode(array_merge(array(
                    \yii::t('app', 'Place'),
                    \yii::t('app', 'Team name'),
                    \yii::t('app', 'Coach name'),
                    \yii::t('app', 'School name'),
                    \yii::t('app', 'Total'),
                    \yii::t('app', 'Penalty'),
                ), $usedLetters))?>,
                colModel: [
                    {name: 'place', index: 'place', width: 60, align: 'center', search: false, frozen: true},
                    {name: 'teamName', index: 'teamName', width: 150, frozen: true},
                    {name: 'coachName<?=ucfirst($lang)?>', index: 'coachName<?=ucfirst($lang)?>', width: 175, frozen: true, formatter: coachShowLink},
                    {name: 'schoolName<?=ucfirst($lang)?>', index: 'schoolName<?=ucfirst($lang)?>', width: 250, frozen: true},
                    {name: 'total', index: 'total', width: 50, search: false, align: 'center', frozen: true},
                    {name: 'penalty', index: 'penalty', width: 50, search: false, align: 'center', frozen: true},
                    <?php foreach ($usedLetters as $letter): ?>
                        {name: '<?=$letter?>', index: '<?=$letter?>', width: 60, align: 'center', search: false},
                    <?php endforeach; ?>
                ],
                postData: {
                    year:   '<?=$year?>',
                    geo:    '<?=$geo?>',
                    phase:  '<?=$phase?>'
                },
                cellEdit: false,
                cmTemplate: {
                    title: false
                },
                scroll: false,
                rowNum: 1000,
                sortname: 'place',
                sortorder: 'asc',
                shrinkToFit: true,
                autowidth: true,
                beforeSelectRow: function() {
                    return false;
                },
                loadComplete: function() {
                    $('[rel=tooltip]').tooltip();
                    $(document).trigger('bootboxconfirm');
                    $('.results-phase-completed').trigger('changed');
                }
            })
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false
            })
            .jqGrid('setGroupHeaders', {
                    useColSpanStyle: true,
                    groupHeaders:[
                        {startColumnName: '<?=reset($usedLetters)?>', numberOfColumns: <?=$tasksCount?>, titleText: '<?=\yii::t('app', 'Tasks')?>'}
                    ]
                }
            )
            .jqGrid('setFrozenColumns');
    });
</script>

<div class="page-header">
    <h1><?=$header?> <small><?=$year?>, <?=\yii::t('app', 'stage')?> <?=$phase?></small></h1>
    <?php if (\yii::app()->user->checkAccess(\common\models\User::ROLE_COORDINATOR_STATE)): ?>
        <div class="dropdown">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?=\yii::t('app', 'Reports')?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a target="_blank" href="<?=$this->createUrl('/staff/reports/participants', array('phase' => $phase, 'year' => $year, 'geo' => $geo))?>">
                        <?=\yii::t('app', 'Participants')?>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="<?=$this->createUrl('/staff/reports/winners', array('phase' => $phase, 'year' => $year, 'geo' => $geo))?>">
                        <?=\yii::t('app', 'Winners')?>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>

<table id="results" style="width: 100%;"></table>

<input type="hidden" name="results-phase" value="<?=$phase?>" />