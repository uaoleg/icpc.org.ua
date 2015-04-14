<?php

namespace common\models\Team\Validator;

use \common\ext\MongoDb\Validator\AbstractValidator;
use \common\models\Team;

class Unique extends AbstractValidator
{

    /**
     * Validate name
     *
     * @param Team $team
     * @param string $attribute
     */
    protected function validateAttribute($team, $attribute)
    {
        if (!$team->attributeHasChanged($attribute)) {
            return;
        }

        $name = $team->$attribute;
        $year = $team->year;

        $team2 = Team::model()->findByAttributes(array(
            'name' => new \MongoRegex('/^' . preg_quote($name) . '$/i'),
            'year' => $year,
        ));

        if ($team2 !== null && ($team2->_id != $team->_id)) {
            $this->addError($team, $attribute, \yii::t('app', 'Team "{name}" already exists for year {year}', array(
                '{name}' => $name,
                '{year}' => $year,
            )));
        }

    }
}