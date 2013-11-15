<div class="btn-group">
    <?php if (\yii::app()->params['yearFirst'] < date('Y')): ?>
        <button class="btn btn-default active dropdown-toggle" data-toggle="dropdown">
            <?=\yii::t('app', '{year} year', array(
                '{year}' => $this->checked,
            ))?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <?php foreach (range(date('Y'), \yii::app()->params['yearFirst']) as $year): ?>
                <?php if ($this->checked === $year) continue; ?>
                <li><a href="<?=\yii::app()->controller->createUrl('', array('year' => $year))?>"><?=\yii::t('app', '{year} year', array(
                    '{year}' => $year,
                ))?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <button class="btn btn-default active" data-toggle="dropdown">
            <?=\yii::t('app', '{year} year', array(
                '{year}' => date('Y'),
            ))?>
        </button>
    <?php endif; ?>
</div>