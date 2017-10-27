<?php

namespace frontend\modules\staff\search;

use \common\components\Message;
use \yii\data\ActiveDataProvider;

class LangSearch extends BaseSearch
{

    /**
     * Search fields
     */
    public $language;
    public $message;
    public $translation;

    /**
     * Returns the validation rules for attributes
     * @return array
     */
    public function rules()
    {
        return [
            [['language', 'message', 'translation'], 'trim'],
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
        $query = Message\Item::find();

        // Setup data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['language' => SORT_ASC],
                'attributes' => [
                    'language',
                    'message',
                    'translation',
                ],
            ],
        ]);

        // No search? Then return data provider
        if (!$this->searching) {
            return $dataProvider;
        }

        // Search
        $query
            ->andFilterWhere(['language' => $this->language])
            ->andFilterWhere(['message' => $this->message])
            ->andFilterWhere(['translation' => $this->translation])
        ;

        return $dataProvider;
    }

}
