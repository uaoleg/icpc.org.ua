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
     * Redirect after document deleted
     * @var string
     */
    public $afterDeleteRedirect = '';

    /**
     * Run widget
     */
    public function run()
    {
        // Render view
        $this->render('row');
    }

}