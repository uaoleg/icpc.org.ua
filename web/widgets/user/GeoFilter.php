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
        // Get school
        $school = \yii::app()->user->getInstance()->school;

        // Render view
        if (!$school->isNewRecord) {
            $this->render('geoFilter', array(
                'school' => $school,
            ));
        } else {
            $this->render('geoFilterWithoutSchool');
        }
    }

}