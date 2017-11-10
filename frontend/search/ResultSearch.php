<?php

namespace frontend\search;

use \common\models\Result;
use \common\models\School;
use \common\models\Team;
use \common\models\User;
use \yii\data\ActiveDataProvider;

class ResultSearch extends BaseSearch
{

    /**
     * @var int
     */
    public $year;

    /**
     * @var int
     */
    public $phase;

    /**
     * @var string
     */
    public $geo;

    /**
     * Search fields
     */
    public $teamName;
    public $coachName;
    public $schoolName;

    /**
     * Returns the validation rules for attributes
     * @return array
     */
    public function rules()
    {
        return [
            [['year', 'phase', 'geo'], 'required'],
            [['teamName', 'coachName', 'schoolName'], 'trim'],
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
        $query = Result::find()
            ->alias('result')
            ->leftJoin(['team' => Team::tableName()], 'team.id = result.teamId')
            ->andWhere([
                'result.year'    => $this->year,
                'result.phase'  => $this->phase,
                'result.geo'    => $this->geo,
            ])
            ->groupBy('result.id')
        ;

        // Setup data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['place' => SORT_ASC],
                'attributes' => [
                    'place',
                    'total',
                    'penalty',
                ],
            ],
        ]);

        // No search? Then return data provider
        if (!$this->searching) {
            return $dataProvider;
        }

        // Apply search filter by team name
        if (!empty($this->teamName)) {
            $query
                ->andWhere('team.name LIKE :teamName', [
                    ':teamName' => "%{$this->teamName}%",
                ])
            ;
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

        // Apply search filter by school name
        if (!empty($this->schoolName)) {
            $query
                ->innerJoin(['school' => School::tableName()], 'school.id = team.schoolId')
                ->andWhere('school.fullNameUk LIKE :schoolName OR school.fullNameEn LIKE :schoolName', [
                    ':schoolName' => "%{$this->schoolName}%",
                ])
            ;
        }

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

}
