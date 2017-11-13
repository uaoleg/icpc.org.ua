<?php

namespace frontend\modules\staff\search;

use \common\models\User;

class CoachSearch extends UserSearch
{

    /**
     * Returns base search query
     * @return \yii\widgets\ActiveForm
     */
    public function baseQuery()
    {
        $query = parent::baseQuery();
        $query->andWhere(['user.type' => User::ROLE_COACH]);

        // Filter by status
        switch ($this->status) {
            case static::STATUS_ACTIVE:
                $query->andFilterWhere(['user.isApprovedCoach' => true]);
                break;
            case static::STATUS_SUSPENDED:
                $query->andFilterWhere(['user.isApprovedCoach' => false]);
                break;
        }

        return $query;
    }

}
