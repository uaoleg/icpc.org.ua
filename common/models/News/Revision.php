<?php

namespace common\models\News;

class Revision extends \common\ext\MongoDb\Document
{

    /**
     * ID of the news
     * @var string
     */
    public $newsId;

    /**
     * ID of the user
     * @var string
     */
    public $userId;

    /**
     * Attributes of the news
     * @var array
     */
    public $newsAttributes;

    /**
     * Timestamp of the revision creation
     * @var int
     */
    public $timestamp;

    /**
     * This returns the name of the collection for this class
     * @return string
     */
    public function getCollectionName()
    {
        return 'news.revisions';
    }

    /**
     * Returns the attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to
     * merge the parent labels with child labels using functions like array_merge().
     *
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
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('newsId, userId, newsAttributes, timestamp', 'required')
        ));
    }

    /**
     * Before validate action
     * @return bool
     */
    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) return false;

        // type casting
        $this->setAttributes(array(
            'newsId'        => (string)$this->newsId,
            'userId'        => (string)$this->userId,
            'timestamp'     => (int)$this->timestamp
        ), false);

        return true;
    }
}
