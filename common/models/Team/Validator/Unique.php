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

        // Find 2nd team with such name
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('_id', '!=', $team->_id)
            ->addCond('name', '==', new \MongoRegex('/^' . preg_quote($name) . '$/i'))
            ->addCond('year', '==', $year)
            ->addCond('isDeleted', '==', false);
        $team2 = Team::model()->find($criteria);

        // If 2nd team exists then add error
        if ($team2 !== null) {
            $this->addError($team, $attribute, \yii::t('app', 'Team "{name}" already exists for year {year}', array(
                '{name}' => $name,
                '{year}' => $year,
            )));
        }

    }
}