<?php

namespace frontend\widgets\filter;

use \frontend\widgets\BaseWidget;

/**
 * Renders year filter
 */
class Year extends BaseWidget
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
        return $this->render('year', [
            'checked' => $this->checked,
        ]);
    }

}