<?php

namespace common\models\News;

use \common\models\BaseActiveRecord;

/**
 * New publishing log
 *
 * @property int    $newsId
 * @property int    $revisionId
 * @property int    $userId
 * @property bool   $isPublished
 * @property int    $timeCreated
 * @property int    $timeUpdated
 */
class PublishLog extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%news_publish_log}}';
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
            'newsId'        => \yii::t('app', 'News ID'),
            'revisionId'    => \yii::t('app', 'Revision ID'),
            'userId'        => \yii::t('app', 'ID of the user who made this change'),
            'isPublished'   => \yii::t('app', 'New status'),
        ));
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['newsId', 'revisionId', 'userId'], 'required'],
            ['isPublished', 'boolean'],
        ]);
    }

}
