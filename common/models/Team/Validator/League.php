<?php

namespace common\models\Team\Validator;

use common\models\Result;
use \common\models\Team;

class League extends \common\ext\MongoDb\Validator\AbstractValidator
{
    /**
     * Validate league
     * @param Team   $team
     * @param string $attribute
     */
    public function validateAttribute($team, $attribute)
    {
        if (!$team->attributeHasChanged($attribute)) {
            return;
        }

        if (!in_array($team->$attribute, Team::model()->getConstantList('LEAGUE_'))) {
            $this->addError($team, $attribute, \yii::t('app', 'Invalid value for {attr}', array('{attr}' => $attribute)));
        };

        if ($team->phase !== Result::PHASE_3) {
            $this->addError($team, $attribute,
                \yii::t('app', 'Cannot set {attr} unless phase is {phase}', array('{attr}' => $attribute, '{phase}' => Result::PHASE_3))
            );
        }
    }

}
