<?php

namespace common\models\Team\Validator;

use \common\models\Team;

class School extends \common\ext\MongoDb\Validator\AbstractValidator
{

    /**
     * Validate assigned school
     *
     * @param Team $team
     * @param string $attribute
     */
	public function validateAttribute($team, $attribute)
	{
        if (!$team->attributeHasChanged($attribute)) {
            return;
        }

        if ($team->school !== null) {
            $team->school->scenario = \common\models\School::SC_ASSIGN_TO_TEAM;
            $team->school->validate();
            if ($team->school->hasErrors()) {
                $this->addError($team, $attribute, \yii::t('app', 'Assigned school is invalid.'));
            }
        } else {
            $this->addError($team, $attribute, \yii::t('app', 'Assigned school not found.'));
        }
	}

}