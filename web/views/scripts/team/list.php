<ul>
    <?php foreach ($teams as $team) : ?>
        <li><?=CHtml::encode($team->name)?></li>
    <?php endforeach; ?>
</ul>