<?php

namespace frontend\search;

use \common\models\Geo\Region;
use \common\models\Geo\State;
use \common\models\School;
use \common\models\Team;
use \common\models\User;
use \yii\data\ActiveDataProvider;

class TeamSearch extends BaseSearch
{

    /**
     * @var int
     */
    public $year;

    /**
     * Search fields
     */
    public $teamName;
    public $schoolName;
    public $schoolType;
    public $coachName;
    public $region;
    public $state;
    public $isOutOfCompetition;
    public $phase = 1;

    /**
     * Returns the validation rules for attributes
     * @return array
     */
    public function rules()
    {
        return [
            ['year', 'required'],
            [['teamName', 'schoolName', 'schoolType', 'coachName'], 'trim'],
            [['region', 'state', 'isOutOfCompetition', 'phase'], 'safe'],
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
        $query = Team::find()
            ->alias('team')
            ->innerJoin(['school' => School::tableName()], 'school.id = team.schoolId')
            ->andWhere([
                'team.year' => $this->year,
                'team.phase' => $this->phase,
            ])
            ->groupBy('team.id')
        ;

        // Setup data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['teamName' => SORT_ASC],
                'attributes' => [
                    'teamName' => [
                        'asc' => ['team.name' => \SORT_ASC],
                        'desc' => ['team.name' => \SORT_DESC],
                    ],
                ],
            ],
        ]);

        // No search? Then return data provider
        if (!$this->searching) {
            return $dataProvider;
        }

        // Apply search filter by school name
        if (!empty($this->schoolName)) {
            $query->andWhere('school.fullNameUk LIKE :schoolName OR school.fullNameEn LIKE :schoolName', [
                ':schoolName' => "%{$this->schoolName}%",
            ]);
        }

        // Apply search filter by coach name
        if (!empty($this->coachName)) {
            $coachName = explode(' ', $this->coachName);
            sort($coachName);
            $coachName = implode('%', $coachName);
            $query
                ->innerJoin(['coach' => User::tableName()], 'coach.id = team.coachId')
                ->andWhere('coach.nameTags LIKE :coachName', [
                    ':coachName' => "%{$coachName}%",
                ])
            ;
        }

        // Apply search filter by competition status
        if (!empty($this->isOutOfCompetition)) {
            $query
                ->andWhere(['team.isOutOfCompetition' => ($this->isOutOfCompetition === 'yes' ? true : false)])
            ;
        }

        // Apply search filters
        $query
            ->andFilterWhere(['LIKE', 'team.name', $this->teamName])
            ->andFilterWhere(['school.type' => $this->schoolType])
            ->andFilterWhere(['school.region' => $this->region])
            ->andFilterWhere(['school.state' => $this->state])
        ;

        return $dataProvider;
    }

    /**
     * Returns list of available school types
     * @return array
     */
    public function filterSchoolTypeOptions()
    {
        $list = ['' => \yii::t('app', 'All')];
        foreach (School::getConstants('TYPE_') as $type) {
            $list[$type] = School::getConstantLabel($type);
        }
        return $list;
    }

    /**
     * Returns list of available regions
     * @return array
     */
    public function filterRegionOptions()
    {
        $list = [];
        foreach (Region::getConstants('NAME_') as $region) {
            $list[$region] = Region::getConstantLabel($region);
        }
        $collator = new \Collator(\yii::$app->language);
        $collator->asort($list);
        return ['' => \yii::t('app', 'All')] + $list;
    }

    /**
     * Returns list of available states
     * @return array
     */
    public function filterStateOptions()
    {
        $list = [];
        foreach (State::getConstants('NAME_') as $state) {
            $list[$state] = State::getConstantLabel($state);
        }
        $collator = new \Collator(\yii::$app->language);
        $collator->asort($list);
        return ['' => \yii::t('app', 'All')] + $list;
    }

}
