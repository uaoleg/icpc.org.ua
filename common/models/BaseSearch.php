<?php

namespace common\models;

use \yii\data\ActiveDataProvider;

class BaseSearch extends BaseModel
{

    /**
     * Is any of search attributes loaded
     * @var bool
     */
    public $searching;

    /**
     * Search
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        if (isset($params[$this->formName()])) {
            $params = array_filter($params[$this->formName()]);
        } else {
            $params = [];
        }
        $this->searching = ($this->load($params, '') && $this->validate());
    }

}
