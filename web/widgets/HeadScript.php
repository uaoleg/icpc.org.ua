<?php

namespace web\widgets;

/**
 * Renders head script for layout
 */
class HeadScript extends \web\ext\Widget
{

    /**
     * Run widget
     */
    public function run()
    {
        // Render view
        $this->render('headScript');
    }

}