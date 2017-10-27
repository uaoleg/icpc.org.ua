<?php

namespace frontend\components;

use \frontend\widgets\Block;

class View extends \yii\web\View
{

    /**
     * Begins recording a block.
     * This method is a shortcut to beginning [[Block]]
     * @param string $id the block ID.
     * @param boolean $renderInPlace whether to render the block content in place.
     * Defaults to false, meaning the captured block will not be displayed.
     * @return Block the Block widget instance
     */
    public function beginBlock($id, $renderInPlace = false)
    {
        return Block::begin([
            'id'            => $id,
            'concatenate'   => true,
            'renderInPlace' => $renderInPlace,
            'view'          => $this,
        ]);
    }

    /**
     * Ends recording a block.
     */
    public function endBlock()
    {
        Block::end();
    }

}
