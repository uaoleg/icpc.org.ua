<?php

namespace frontend\widgets;

/**
 * Renders head script for layout
 */
class HeadScript extends BaseWidget
{

    /**
     * Run widget
     */
    public function run()
    {
        // Render view
        return $this->render('headScript');
    }

}