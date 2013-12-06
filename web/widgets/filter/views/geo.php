<script type="text/javascript">
    $(document).ready(function() {
        $('ul[data-sort=1]').sortList();
    });
</script>

<div class="btn-group">
    <a href="<?=\yii::app()->controller->createUrl('', array('geo' => $school->country))?>"
       class="btn btn-default <?=$countryChecked ? 'active' : ''?>">
        <?=$countryLabel?>
    </a>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle <?=$regionChecked ? 'active' : ''?>" data-toggle="dropdown">
            <?=$regionLabel?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <?php foreach (\common\models\Geo\Region::model()->getConstantList('NAME_') as $region): ?>
            <li><a href="<?=\yii::app()->controller->createUrl('', array('geo' => $region))?>">
                <?=\common\models\Geo\Region::model()->getAttributeLabel($region, 'name')?>
            </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle <?=$stateChecked ? 'active' : ''?>" data-toggle="dropdown">
            <?=$stateLabel?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" data-sort="1">
            <?php foreach (\common\models\Geo\State::model()->getConstantList('NAME_') as $state): ?>
            <li><a href="<?=\yii::app()->controller->createUrl('', array('geo' => $state))?>">
                <?=\common\models\Geo\State::model()->getAttributeLabel($state, 'name')?>
            </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>