<?php

namespace common\models\Team\Validator;

use \common\models\Team;

class Unique extends \yii\validators\Validator
{

    /**
     * Validate team to be unique
     * @param Team $team
     * @param string $attribute
     */
    public function validateAttribute($team, $attribute)
    {
        if (!$team->isAttributeChanged($attribute)) {
            return;
        }

        $name = $team->$attribute;
        $year = $team->year;

        // Find 2nd team with such name
        $team2 = Team::find()
            ->andWhere(['!=', 'id', $team->id])
            ->andWhere(['LIKE', 'name', $name])
            ->andWhere([
                'year'      => $year,
                'isDeleted' => false,
            ])
            ->one()
        ;

        // If 2nd team exists then add error
        if ($team2 !== null) {
            $this->addError($team, $attribute, \yii::t('app', 'Team "{name}" already exists for year {year}', array(
                '{name}' => $name,
                '{year}' => $year,
            )));
        }

    }
}