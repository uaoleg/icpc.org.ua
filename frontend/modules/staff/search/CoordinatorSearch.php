<?php

namespace frontend\modules\staff\search;

use \common\models\User;

class CoordinatorSearch extends UserSearch
{

    /**
     * Returns base search query
     * @return \yii\widgets\ActiveForm
     */
    public function baseQuery()
    {
        $query = parent::baseQuery();
        $query->andWhere([
            'user.coordinator' => [
                User::ROLE_COORDINATOR_STATE,
                User::ROLE_COORDINATOR_REGION,
                User::ROLE_COORDINATOR_UKRAINE,
            ]
        ]);
        return $query;
    }

}
