<?php

namespace web\widgets\document;

/**
 * Renders document row
 */
class Row extends \web\ext\Widget
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
        // Render view
        $this->render('row');
    }

}