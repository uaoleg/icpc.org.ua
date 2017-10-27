<?php

namespace common\models\Team\Validator;

use \common\models\Team;

class Phase extends \yii\validators\Validator
{

    /**
     * Validate team phase
     * @param Team $team
     * @param string $attribute
     */
	public function validateAttribute($team, $attribute)
	{
        if (!$team->isAttributeChanged($attribute)) {
            return;
        }

        // Can increase the Stage Number by only 1
        if ($team->phase - 1 > $team->getOldAttribute('phase')) {
            $this->addError($team, $attribute, \yii::t('app', 'Can increase the Stage Number by only 1.'));
        }
	}

}