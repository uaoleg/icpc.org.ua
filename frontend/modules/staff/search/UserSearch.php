<?php

namespace frontend\modules\staff\search;

use \common\models\Geo\State;
use \common\models\School;
use \common\models\User;
use \yii\data\ActiveDataProvider;

class UserSearch extends BaseSearch
{

    /**
     * Search fields
     */
    public $name;
    public $email;
    public $state;
    public $status;

    const STATUS_ALL        = '';
    const STATUS_ACTIVE     = 'active';
    const STATUS_SUSPENDED  = 'suspended';

    /**
     * Returns the validation rules for attributes
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'trim'],
            ['state', 'in', 'range' => State::getConstants('NAME_')],
            ['status', 'safe'],
        ];
    }

    /**
     * Returns base search query
     * @return \yii\db\ActiveQuery
     */
    public function baseQuery()
    {
        return User::find()->alias('user');
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
        $query = $this->baseQuery();

        // Setup data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['timeCreated' => SORT_DESC],
                'attributes' => [
                    'timeCreated' => [
                        'asc' => ['user.timeCreated' => \SORT_ASC],
                        'desc' => ['user.timeCreated' => \SORT_DESC],
                    ],
                ],
            ],
        ]);

        // No search? Then return data provider
        if (!$this->searching) {
            return $dataProvider;
        }

        // Apply search filter by name
        if (!empty($this->name)) {
            $name = explode(' ', $this->name);
            sort($name);
            $name = implode('%', $name);
            $query
                ->andWhere('user.nameTags LIKE :name', [
                    ':name' => "%{$name}%",
                ])
            ;
        }

        // Apply search filter by email
        if (!empty($this->email)) {
            $query
                ->andWhere(['LIKE', 'user.email', $this->email])
            ;
        }

        // Apply filter by state
        if (!empty($this->state)) {
            $query
                ->innerJoin(['school' => School::tableName()], 'school.id = user.schoolId')
                ->andWhere(['school.state' => $this->state])
            ;
        }

        return $dataProvider;
    }

    /**
     * Returns list of available states
     * @return array
     */
    public function filterStateOptions()
    {
        return ['' => \yii::t('app', 'All states')] + State::constantLabels();
    }

    /**
     * Returns list of available states
     * @return array
     */
    public function filterStatusOptions()
    {
        return [
            static::STATUS_ALL          => \yii::t('app', 'All'),
            static::STATUS_SUSPENDED    => \yii::t('app', 'Suspended'),
            static::STATUS_ACTIVE       => \yii::t('app', 'Active'),
        ];
    }

}
