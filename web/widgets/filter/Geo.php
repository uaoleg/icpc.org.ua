<?php

namespace web\widgets\filter;

/**
 * Renders geo filter
 */
class Geo extends \web\ext\Widget
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
        $this->render('geo', array(
            'user' => \yii::app()->user->getInstance(),
        ));
    }

}