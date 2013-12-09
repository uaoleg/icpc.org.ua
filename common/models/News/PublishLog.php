<?php

namespace common\models\News;

class PublishLog extends \common\ext\MongoDb\Document
{

    /**
     * ID of the news
     * @var string
     */
    public $newsId;

    /**
     * ID of the revision which status was changed
     * @var string
     */
    public $revisionId;

    /**
     * ID of the user who made this change
     * @var string
     */
    public $userId;

    /**
     * Status in which news was changed to
     * @var bool
     */
    public $isPublished;

    /**
     * Timestamp when this change was made
     * @var int
     */
    public $timestamp;

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
            'newsId'        => \yii::t('app', 'News ID'),
            'revisionId'    => \yii::t('app', 'Revision ID'),
            'userId'        => \yii::t('app', 'ID of the user who made this change'),
            'isPublished'   => \yii::t('app', 'New status'),
            'timestamp'     => \yii::t('app', 'Timestamp of the change'),
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
            array('newsId, revisionId, userId, timestamp', 'required')
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'news.publishLog';
    }

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'newsId_timestamp' => array(
                'key' => array(
                    'newsId'    => \EMongoCriteria::SORT_ASC,
                    'timestamp' => \EMongoCriteria::SORT_DESC,
                ),
            ),
        ));
    }

    /**
     * Before validate action
     * @return bool
     */
    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        // Set timestamp
        if (empty($this->timestamp)) {
            $this->timestamp = time();
        }

        // Type casting
        $this->setAttributes(array(
            'newsId'        => (string)$this->newsId,
            'revisionId'    => (string)$this->revisionId,
            'userId'        => (string)$this->userId,
            'isPublished'   => (bool)$this->isPublished,
        ), false);

        return true;
    }
}
