<?php

namespace web\widgets\filter;

use common\models\Geo\Region;
use common\models\Geo\State;

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
        // Get school
        $school = \common\models\School::model();

        // Define labels
        $countryChecked = false;
        $regionChecked  = false;
        $stateChecked   = false;
        $countryLabel   = $school->countryLabel;
        $regionLabel    = \yii::t('app', 'Region');
        $stateLabel     = \yii::t('app', 'State');
        if ($this->checked === $school->country) {
            $countryChecked = true;
        } elseif (in_array($this->checked, Region::model()->getConstantList('NAME_'))) {
            $regionChecked  = true;
            $regionLabel    = Region::model()->getAttributeLabel($this->checked);
        } elseif (in_array($this->checked, State::model()->getConstantList('NAME_'))) {
            $stateChecked   = true;
            $stateLabel     = State::model()->getAttributeLabel($this->checked);
        }

        // Render view
        $this->render('geo', array(
            'school'            => $school,
            'countryChecked'    => $countryChecked,
            'regionChecked'     => $regionChecked,
            'stateChecked'      => $stateChecked,
            'countryLabel'      => $countryLabel,
            'regionLabel'       => $regionLabel,
            'stateLabel'        => $stateLabel,
        ));
    }

}