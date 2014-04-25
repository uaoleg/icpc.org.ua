<?php

namespace common\models\Team\Validator;

use \common\models\Team;
use \common\models\User;

class Members extends \common\ext\MongoDb\Validator\AbstractValidator
{

    /**
     * Validate assigned members
     *
     * @param Team $team
     * @param string $attribute
     */
	public function validateAttribute($team, $attribute)
	{
        if (!$team->attributeHasChanged($attribute)) {
            return;
        }

        if (count($team->memberIds) < 3) {
            $this->addError($team, $attribute, \yii::t('app', 'The number of members should be greater or equal then 3.'));
        } elseif (count($team->memberIds) > 4) {
            $this->addError($team, $attribute, \yii::t('app', 'The number of members should be less or equal then 4.'));
        } else {
            // Check if user tries to add user who is already is some other team
            $teams = Team::model()->findAllByAttributes(array(
                '_id' => array('$ne' => $team->_id),
                'year' => $team->year,
                'memberIds' => array('$in' => $team->memberIds)
            ));
            foreach ($teams as $_team) {
                $userIds = array_intersect($team->memberIds, $_team->memberIds);

                foreach ($userIds as $userId) {
                    $user = User::model()->findByPk(new \MongoId((string)$userId));
                    $this->addError($team, $attribute, \yii::t('app', '{name} is already in another team.', array(
                        '{name}' => \web\widgets\user\Name::create(array('user' => $user), true)
                    )));
                }
            }
        }
	}

}