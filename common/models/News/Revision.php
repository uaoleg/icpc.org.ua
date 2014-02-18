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
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'news.revision';
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
     *
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

        // Set user ID
        if ((empty($this->userId)) && (\yii::app()->hasComponent('user'))) {
           $this->userId = \yii::app()->user->id;
        }

        // Type casting
        $this->setAttributes(array(
            'newsId'        => (string)$this->newsId,
            'userId'        => (string)$this->userId,
        ), false);

        return true;
    }
}
