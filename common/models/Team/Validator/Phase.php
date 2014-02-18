<?php

namespace common\models\Team\Validator;

use \common\models\Team;

class Phase extends \common\ext\MongoDb\Validator\AbstractValidator
{

    /**
     * Validate phase
     *
     * @param Team $team
     * @param string $attribute
     */
	public function validateAttribute($team, $attribute)
	{
        if (!$team->attributeHasChanged($attribute)) {
            return;
        }

        // Can increase the Stage Number by only 1
        if ($team->phase - 1 > $team->attributeInitValue('phase')) {
            $this->addError($team, $attribute, \yii::t('app', 'Can increase the Stage Number by only 1.'));
        }
	}

}