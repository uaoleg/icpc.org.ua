<?php

namespace web\widgets\filter;

/**
 * Renders year filter
 */
class Year extends \web\ext\Widget
{

    /**
     * Checked value
     * @var string
     */
    public $checked;

    /**
     * Run widget
     */
    public function run()
    {
        // Render view
        $this->render('year');
    }

}