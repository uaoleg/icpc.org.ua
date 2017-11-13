<?php

namespace common\models\News;

use \common\models\BaseActiveRecord;

/**
 * Image
 *
 * @property int    $newsId
 * @property int    $userId
 * @property string $content
 */
class Image extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%news_image}}';
    }

    /**
     * Returns a list of behaviors that this component should behave as
     * @return array
     */
    public function behaviors()
    {
        return [
            $this->behaviorTimestamp(),
        ];
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'newsId' => \yii::t('app', 'ID of the news'),
        ));
    }

    /**
     * Define attribute rules
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['newsId', 'safe'],
            [['userId', 'content'], 'required'],
        ]);
    }

}
