<?php

namespace frontend\modules\staff\search;

use \common\models\Geo\State;
use \common\models\School;
use \yii\data\ActiveDataProvider;

class OrganizationSearch extends BaseSearch
{

    /**
     * Search fields
     */
    public $fullNameUk;
    public $shortNameUk;
    public $fullNameEn;
    public $shortNameEn;
    public $type;
    public $state;

    /**
     * Returns the validation rules for attributes
     * @return array
     */
    public function rules()
    {
        return [
            [['fullNameUk', 'shortNameUk', 'fullNameEn', 'shortNameEn'], 'trim'],
            [['type', 'state'], 'safe'],
        ];
    }

    /**
     * Search
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        parent::search($params);

        // Create base query
        $query = School::find();

        // Setup data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['fullNameUk' => SORT_ASC],
                'attributes' => [
                    'fullNameUk',
                    'shortNameUk',
                    'fullNameEn',
                    'shortNameEn',
                    'type',
                    'state',
                ],
            ],
        ]);

        // No search? Then return data provider
        if (!$this->searching) {
            return $dataProvider;
        }

        // Search
        $query
            ->andFilterWhere(['LIKE', 'fullNameUk', $this->fullNameUk])
            ->andFilterWhere(['LIKE', 'shortNameUk', $this->shortNameUk])
            ->andFilterWhere(['LIKE', 'fullNameEn', $this->fullNameEn])
            ->andFilterWhere(['LIKE', 'shortNameEn', $this->shortNameEn])
            ->andFilterWhere(['type' => $this->type])
            ->andFilterWhere(['state' => $this->state])
        ;

        return $dataProvider;
    }

    /**
     * Returns list of available school types
     * @return array
     */
    public function filterTypeOptions()
    {
        $types = [];
        foreach (School::getConstants('TYPE_') as $type) {
            $types[$type] = School::getConstantLabel($type);
        }
        return ['' => \yii::t('app', 'All')] + $types;
    }

    /**
     * Returns list of available states
     * @return array
     */
    public function filterStateOptions()
    {
        return ['' => \yii::t('app', 'All states')] + State::constantLabels();
    }

}
