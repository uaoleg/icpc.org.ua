<?php

namespace common\models\Team\Validator;

use \common\models\Result;
use \common\models\Team;

class League extends \yii\validators\Validator
{
    /**
     * Validate team league
     * @param Team   $team
     * @param string $attribute
     */
    public function validateAttribute($team, $attribute)
    {
        if (!$team->isAttributeChanged($attribute)) {
            return;
        }

        // Check league to be valid
        if (!in_array($team->$attribute, Team::getConstants('LEAGUE_'))) {
            $this->addError($team, $attribute, \yii::t('app', 'Invalid value for {attribute}'));
        };

        // Team should be at least on 3rd phase (or complete it)
        if (($team->phase < Result::PHASE_3) && ($team->$attribute !== Team::LEAGUE_NULL)) {
            $this->addError($team, $attribute,
                \yii::t('app', 'Cannot set {attribute} unless phase is {phase}', ['phase' => Result::PHASE_3])
            );
        }
    }

}
