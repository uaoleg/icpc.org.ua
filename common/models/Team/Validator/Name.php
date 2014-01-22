<?php

namespace common\models\Team\Validator;

use \common\models\Team;

class Name extends \common\ext\MongoDb\Validator
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

        // Check if name contains only prefix
        $teamName = $team->name;
        $schoolShortNameEn = $team->school->shortNameEn;
        if (mb_strlen($teamName) <= mb_strlen($schoolShortNameEn)) {
            $this->addError($team, $attribute, \yii::t('app', 'Team name cannot be empty'));
        }
	}

}