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
        return $query;
    }

}
