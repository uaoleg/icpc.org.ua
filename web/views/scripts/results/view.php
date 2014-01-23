<?php
    \yii::app()->getClientScript()->registerCoreScript('jquery.jqgrid');
?>

<script type="text/javascript">
    $(document).ready(function(){

        new appResultsView();

        $('#results')
            .jqGrid({
                url: '<?=$this->createUrl('/results/GetResultsListJson')?>',
                datatype: 'json',
                colNames: [
                    '<?=\yii::t('app', 'Place')?>',
                    '<?=\yii::t('app', 'Team name')?>',
                    '<?=\yii::t('app', 'Coach name')?>',
                    '<?=\yii::t('app', 'School name')?>',
                    '<?=\yii::t('app', 'Total')?>',
                    '<?=\yii::t('app', 'Penalty')?>',
                    <?php for ($i = 0; $i < $tasksCount; $i++): ?>
                        '<?=$letters[$i]?>',
                    <?php endfor; ?>
                ],
                colModel: [
                    {name: 'place', index: 'place', width: 60, align: 'center', search: false, frozen: true},
                    {name: 'teamName', index: 'teamName', width: 150, frozen: true},
                    {name: 'coachName<?=ucfirst(\yii::app()->language)?>', index: 'coachName<?=ucfirst(\yii::app()->language)?>', width: 175, frozen: true},
                    {name: 'schoolName<?=ucfirst(\yii::app()->language)?>', index: 'schoolName<?=ucfirst(\yii::app()->language)?>', width: 250, frozen: true},
                    {name: 'total', index: 'total', width: 50, search: false, align: 'center', frozen: true},
                    {name: 'penalty', index: 'penalty', width: 50, search: false, align: 'center', frozen: true},
                    <?php for ($i = 0; $i < $tasksCount; $i++): ?>
                        {name: '<?=$letters[$i]?>', index: '<?=$letters[$i]?>', width: 60, align: 'center', search: false},
                    <?php endfor; ?>
                ],
                postData: {
                    year:   '<?=$year?>',
                    geo:    '<?=$geo?>',
                    phase:  '<?=$phase?>'
                },
                cellEdit: false,
                scroll: false,
                rowNum: 100,
                sortname: 'place',
                sortorder: 'asc',
                shrinkToFit: false,
                beforeSelectRow: function() {
                    return false;
                },
                loadComplete: function() {
                    $('[rel=tooltip]').tooltip();
                }
            })
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false
            })
            .jqGrid('setGroupHeaders', {
                    useColSpanStyle: true,
                    groupHeaders:[
                        {startColumnName: '<?=$letters[0]?>', numberOfColumns: <?=$tasksCount?>, titleText: '<?=\yii::t('app', 'Tasks')?>'}
                    ]
                }
            )
            .jqGrid('setFrozenColumns');
    });
</script>

<div class="page-header">
    <h1><?=$header?> <small><?=$year?>, <?=\yii::t('app', 'phase')?> <?=$phase?></small></h1>
</div>

<table id="results" style="width: 100%;"></table>

<input type="hidden" name="results-phase" value="<?=$phase?>" />