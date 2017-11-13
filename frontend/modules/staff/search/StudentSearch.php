<?php

namespace frontend\modules\staff\search;

use \common\models\User;

class StudentSearch extends UserSearch
{

    /**
     * Returns base search query
     * @return \yii\widgets\ActiveForm
     */
    public function baseQuery()
    {
        $query = parent::baseQuery();
        $query->andWhere(['user.type' => User::ROLE_STUDENT]);

        // Filter by status
        switch ($this->status) {
            case static::STATUS_ACTIVE:
                $query->andFilterWhere(['user.isApprovedStudent' => true]);
                break;
            case static::STATUS_SUSPENDED:
                $query->andFilterWhere(['user.isApprovedStudent' => false]);
                break;
        }

        return $query;
    }

}
