<?php foreach ($itemList as $item): ?>
    <?php if (\yii::app()->rbac->isForCustomers($item->name)) continue; ?>
    <label rel="tooltip"
           title="<?=\CHtml::encode($item->description)?>"
           data-placement="right"
           style="display: inline;">
        <input type="checkbox"
               data-name="<?=$item->name?>"
               <?=\yii::app()->authManager->hasItemChild($this->role->name, $item->name) ? 'checked' : ''?>
               <?=(in_array($this->role->name, array('admin', 'staff'))) ? 'disabled' : ''?>
               style="margin: 0;" />
        <?=$item->name?>
    </label>
    <br />
<?php endforeach; ?>