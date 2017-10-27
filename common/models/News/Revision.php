<?php

namespace common\models\News;

use \common\models\BaseActiveRecord;

/**
 * New revision
 *
 * @property int    $newsId
 * @property int    $userId
 * @property string $newsAttributes
 * @property int    $timeCreated
 * @property int    $timeUpdated
 */
class Revision extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%news_revision}}';
    }

    /**
     * Returns a list of behaviors that this component should behave as
     * @return array
     */
    public function behaviors()
    {
        return [
            $this->behaviorJson(['newsAttributes']),
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
            'newsId'            => \yii::t('app', 'News ID'),
            'userId'            => \yii::t('app', 'ID of the user who created this revision'),
            'newsAttributes'    => \yii::t('app', 'Attributes of news for this revision'),
            'timestamp'         => \yii::t('app', 'Timestamp when revision was created'),
        ));
    }

    /**
     * Define attribute rules
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['newsId', 'userId', 'newsAttributes'], 'required']
        ]);
    }

}
