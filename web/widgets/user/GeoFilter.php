<?php

namespace web\widgets\user;

/**
 * Renders geo filter control for current user
 */
class GeoFilter extends \web\ext\Widget
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
        $this->render('geoFilter', array(
            'user' => \yii::app()->user->getInstance(),
        ));
    }

}