<ul class="<?=$this->class?>">
    <?php foreach ($this->itemList as $itemId => $item): ?>
        <?php $isDropdown = ((isset($item['itemList'])) && (count($item['itemList']) > 0)); ?>
        <li class="<?=$itemId == $this->activeItem ? 'active' : ''?> <?=$isDropdown ? 'dropdown' : ''?>">
            <a href="<?=$item['href']?>"
               class="<?=$isDropdown ? 'dropdown-toggle' : ''?>"
               <?=$isDropdown ? 'data-toggle="dropdown"' : ''?>>
                <?php if (isset($item['icon'])): ?>
                    <i class="<?=$item['icon']?>"></i>
                <?php elseif (isset($item['iconImg'])): ?>
                    <span class="<?=$item['iconImg']?>"></span>
                <?php endif; ?>
                <?=$item['caption']?>
                <?php if ((isset($item['captionAppend'])) && ($item['captionAppend'] !== null)): ?>
                    <span class="<?=isset($item['captionAppendClass']) ? $item['captionAppendClass'] : ''?>">
                        <?=$item['captionAppend']?>
                    </span>
                <?php endif; ?>
                <?php if ($isDropdown): ?>
                    <b class="caret"></b>
                <?php endif; ?>
            </a>
            <?php if ($isDropdown): ?>
                <ul class="dropdown-menu">
                <?php foreach ($item['itemList'] as $subitem): ?>
                    <li>
                        <a href="<?=$subitem['href']?>">
                            <?=$subitem['caption']?>
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>