<?php
    \yii::app()->getClientScript()->registerCoreScript('jquery.jqgrid');
?>

<div class="page-header">
    <h1><?=$header?> <small><?=$year?>, <?=\yii::t('app', 'phase')?> <?=$phase?></small></h1>
</div>


<script type="text/javascript">

    $(document).ready(function(){
        var $table = $('#results');
        $table.jqGrid({
            url: '<?=$this->createUrl('/results/GetResultsListJson')?>',
            datatype: 'json',
            colNames: [
                '<?=\yii::t('app', 'Place')?>',
                '<?=\yii::t('app', 'Team name')?>',
                '<?=\yii::t('app', 'Coach name')?>',
                '<?=\yii::t('app', 'School name')?>',
                <?php for ($i = 0; $i < $tasksCount; $i++): ?>
                    '<?=$letters[$i]?>',
                <?php endfor; ?>
                '<?=\yii::t('app', 'Total')?>',
                '<?=\yii::t('app', 'Penalty')?>',
            ],
            colModel: [
                {name: 'place', index: 'place', width: 2, search: false},
                {name: 'teamName', index: 'teamName', width: 10, formatter: 'showlink', formatoptions:{baseLinkUrl:'/team/view'}},
                {name: 'coachName<?=ucfirst(\yii::app()->language)?>', index: 'coachName<?=ucfirst(\yii::app()->language)?>', width: 10},
                {name: 'schoolName<?=ucfirst(\yii::app()->language)?>', index: 'schoolName<?=ucfirst(\yii::app()->language)?>', width: 10},
                <?php for ($i = 0; $i < $tasksCount; $i++): ?>
                    {name: '<?=$letters[$i]?>', index: '<?=$letters[$i]?>', width: 3, search: false},
                <?php endfor; ?>
                {name: 'total', index: 'total', width: 3, search: false},
                {name: 'penalty', index: 'penalty', width: 3, search: false}
            ],
            caption: '<?=\yii::t('app', 'Results')?>',
            postData: {
                geo: '<?=$geo?>'
            },
            sortname: 'place',
            sortorder: 'asc',
            autowidth: true,
            loadError: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
        $table.jqGrid('filterToolbar', {
            stringResult: true,
            searchOnEnter: false
        });

    });
</script>

<table id="results" style="width: 100%;"></table>