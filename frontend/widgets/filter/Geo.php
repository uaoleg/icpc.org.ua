<?php

namespace frontend\widgets\filter;

use \common\models\Geo\Region;
use \common\models\Geo\State;
use \frontend\widgets\BaseWidget;

/**
 * Renders geo filter
 */
class Geo extends BaseWidget
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
        $school = new \common\models\School;

        // Define labels
        $countryChecked = false;
        $regionChecked  = false;
        $stateChecked   = false;
        $countryLabel   = $school->countryLabel;
        $regionLabel    = \yii::t('app', 'Region');
        $stateLabel     = \yii::t('app', 'State');
        if ($this->checked === $school->country) {
            $countryChecked = true;
        } elseif (in_array($this->checked, Region::getConstants('NAME_'))) {
            $regionChecked  = true;
            $regionLabel    = Region::getConstantLabel($this->checked);
        } elseif (in_array($this->checked, State::getConstants('NAME_'))) {
            $stateChecked   = true;
            $stateLabel     = State::getConstantLabel($this->checked);
        }

        // Render view
        return $this->render('geo', array(
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