<?php

namespace frontend\widgets\user;

use \frontend\widgets\BaseWidget;

/**
 * Renders geo filter control for current user
 */
class GeoFilter extends BaseWidget
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
        $school = \yii::$app->user->identity->school;

        // Render view
        if (!$school->isNewRecord) {
            return $this->render('geoFilter', array(
                'school'    => $school,
                'checked'   => $this->checked,
            ));
        } else {
            return $this->render('geoFilterWithoutSchool', [
                'checked' => $this->checked,
            ]);
        }
    }

}