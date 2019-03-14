<?php

namespace common\models\Team\Validator;

use \common\models\Team;

class Name extends \common\ext\MongoDb\Validator\AbstractValidator
{

    /**
     * Validate name
     *
     * @param Team $team
     * @param string $attribute
     */
	public function validateAttribute($team, $attribute)
	{
        if (!$team->attributeHasChanged($attribute)) {
            return;
        }

        // Get team name
        $teamName = $team->$attribute;

        // Can't be empty
        if (empty($teamName)) {
            $this->addError($team, $attribute, \yii::t('app', 'Team name cannot be empty.'));
            return;
        }

        // Check school prefix
//        if (strpos($teamName, $team->school->shortNameEn) !== 0) {
//            $this->addError($team, $attribute, \yii::t('app', 'Team name should be prefixed with short school name.'));
//            return;
//        }

        // Check if name contains only prefix
        $schoolShortNameEn = $team->school->shortNameEn;
        if (mb_strlen($teamName) <= mb_strlen($schoolShortNameEn)) {
            $this->addError($team, $attribute, \yii::t('app', 'Team name can not consist of short school name only.'));
        }
	}

}