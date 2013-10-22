<?php

namespace common\models;

class News extends \common\ext\MongoDb\Document
{

    /**
     * Common ID for all translations
     * @var string
     */
    public $commonId;

    /**
     * Language code (e.g. "uk", "en_us", etc.)
     * @var string
     */
    public $lang;

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * Content
     * @var string
     */
    public $content;

    /**
     * Whether the news is published
     * @var bool
     */
    public $isPublished = false;

    /**
     * Date created
     * @var int
     */
    public $dateCreated;

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
            'commonId'      => \yii::t('app', 'Common ID'),
            'lang'          => \yii::t('app', 'Language'),
            'title'         => \yii::t('app', 'Title'),
            'content'       => \yii::t('app', 'Content'),
            'isPublished'   => \yii::t('app', 'Is published'),
            'dateCreated'   => \yii::t('app', 'Registration date'),
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
            array('lang, title, content, dateCreated', 'required'),
            array('title', 'length', 'max' => 300),
            array('content', 'length', 'max' => 5000),
        ));
    }

	/**
	 * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'news';
	}

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'commonId' => array(
                'key' => array(
                    'commonId' => \EMongoCriteria::SORT_ASC,
                ),
            ),
            'isPublished_lang_dateCreated' => array(
                'key' => array(
                    'isPublished'   => \EMongoCriteria::SORT_ASC,
                    'lang'          => \EMongoCriteria::SORT_ASC,
                    'dateCreated'   => \EMongoCriteria::SORT_DESC,
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
        if (!parent::beforeValidate()) return false;

        // Convert to string
        $this->commonId = (string)$this->commonId;

        // Convert to bool
        $this->isPublished = (bool)$this->isPublished;

        // Set created date
        if ($this->dateCreated == null) {
            $this->dateCreated = time();
        }

        return true;
    }

    /**
     * After save action
     */
    protected function afterSave()
    {
        // Set common ID
        if (empty($this->commonId)) {
            $this->commonId = (string)$this->_id;
            $this->save();
        }

        parent::afterSave();
    }

}