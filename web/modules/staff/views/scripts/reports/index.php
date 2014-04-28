<div class="pull-right" style="margin-left: 20px;">
    <?php \web\widgets\filter\Year::create(array('checked' => $year)); ?>
</div>

<div class="row">
    <div class="col-lg-12 text-center">
        <a class="btn btn-link btn-lg" href="<?=$this->createUrl('reports/participants')?>"><?=\yii::t('app', 'Participants')?></a>
        <a class="btn btn-link btn-lg" href="<?=$this->createUrl('reports/winners')?>"><?=\yii::t('app', 'Winners')?></a>
    </div>
</div>