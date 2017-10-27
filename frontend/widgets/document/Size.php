<?php

namespace frontend\widgets\document;

use \frontend\widgets\BaseWidget;

/**
 * Renders document size
 */
class Size extends BaseWidget
{

    /**
     * Document
     * @var \common\models\document
     */
    public $document;

    /**
     * Run widget
     */
    public function run()
    {
        $size = mb_strlen($this->document->content);

        if ($size < BYTES_IN_KB) {
            $sizeLabel = $size . ' b';
        } elseif ($size < BYTES_IN_MB) {
            $sizeLabel = number_format($size / BYTES_IN_KB, 2) . ' kb';
        } elseif ($size < BYTES_IN_GB) {
            $sizeLabel = number_format($size / BYTES_IN_MB, 2) . ' mb';
        } else {
            $sizeLabel = number_format($size / BYTES_IN_GB, 2) . ' gb';
        }

        echo $sizeLabel;
    }

}