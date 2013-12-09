<?php
    \yii::app()->getClientScript()->registerCoreScript('jquery.jqgrid');
?>

<div class="page-header">
    <h1><?=$header?> <small><?=$year?>, <?=\yii::t('app', 'phase')?> <?=$phase?></small></h1>
</div>


<script type="text/javascript">

    $(document).ready(function(){
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
                    {name: 'teamName', index: 'teamName', width: 150, formatter: 'showlink', formatoptions:{baseLinkUrl:'/team/view'}, frozen: true},
                    {name: 'coachName<?=ucfirst(\yii::app()->language)?>', index: 'coachName<?=ucfirst(\yii::app()->language)?>', width: 175, frozen: true},
                    {name: 'schoolName<?=ucfirst(\yii::app()->language)?>', index: 'schoolName<?=ucfirst(\yii::app()->language)?>', width: 250, frozen: true},
                    {name: 'total', index: 'total', width: 35, search: false, align: 'center', frozen: true},
                    {name: 'penalty', index: 'penalty', width: 45, search: false, align: 'center', frozen: true},
                    <?php for ($i = 0; $i < $tasksCount; $i++): ?>
                        {name: '<?=$letters[$i]?>', index: '<?=$letters[$i]?>', width: 60, align: 'center', search: false},
                    <?php endfor; ?>
                ],
                postData: {
                    geo: '<?=$geo?>'
                },
                cellEdit: false,
                scroll: false,
                rowNum: 100,
                sortname: 'place',
                sortorder: 'asc',
                shrinkToFit: false,
                loadError: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
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

<table id="results" style="width: 100%;"></table>