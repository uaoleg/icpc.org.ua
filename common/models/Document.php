<?php

namespace common\models;

/**
 * Document
 *
 * @property-read UploadedFile $file
 */
class Document extends \common\ext\MongoDb\Document
{

    /**
     * Available doc types
     */
    const TYPE_GUIDANCE         = 'guidance';
    const TYPE_REGULATIONS      = 'regulations';
    const TYPE_RESULTS_PHASE_1  = 'resultsPhase1';
    const TYPE_RESULTS_PHASE_2  = 'resultsPhase2';
    const TYPE_RESULTS_PHASE_3  = 'resultsPhase3';

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * Description
     * @var string
     */
    public $desc;

    /**
     * Type
     * @var string
     */
    public $type;

    /**
     * File extension
     * @var string
     */
    public $fileExt;

    /**
     * Whether the doc is published
     * @var bool
     */
    public $isPublished = false;

    /**
     * Date created
     * @var int
     */
    public $dateCreated;

    /**
     * Related file
     * @var UploadedFile
     */
    protected $_file;

    /**
     * Returns related file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        if ($this->_file === null) {
            $this->_file = UploadedFile::model()->findByAttributes(array(
                'uniqueId' => $this->getUniqueId(),
            ));
        }
        return $this->_file;
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
            'title'         => \yii::t('app', 'Title'),
            'desc'          => \yii::t('app', 'Description'),
            'type'          => \yii::t('app', 'Type'),
            'fileExt'       => \yii::t('app', 'File extension'),
            'isPublished'   => \yii::t('app', 'Is published'),
            'dateCreated'   => \yii::t('app', 'Registration date'),
            'const.type' => array(
                static::TYPE_GUIDANCE           => \yii::t('app', 'Guidance'),
                static::TYPE_REGULATIONS        => \yii::t('app', 'Regulations'),
                static::TYPE_RESULTS_PHASE_1    => \yii::t('app', '1st Phase Results'),
                static::TYPE_RESULTS_PHASE_2    => \yii::t('app', '2nd Phase Results'),
                static::TYPE_RESULTS_PHASE_3    => \yii::t('app', '3d Phase Results'),
            ),
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
            array('title, type, dateCreated, fileExt', 'required'),
            array('title', 'length', 'max' => 300),
            array('desc', 'length', 'max' => 1000),
        ));
    }

	/**
	 * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'document';
	}

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'isPublished_type_dateCreated' => array(
                'key' => array(
                    'isPublished'   => \EMongoCriteria::SORT_ASC,
                    'type'          => \EMongoCriteria::SORT_ASC,
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

        // Convert to bool
        $this->isPublished = (bool)$this->isPublished;

        // Set created date
        if ($this->dateCreated == null) {
            $this->dateCreated = time();
        }

        return true;
    }

    /**
     * After delete action
     */
    protected function afterDelete()
    {
        // Delete uploaded file
        $criteria = new \EMongoCriteria();
        $criteria->addCond('uniqueId', '==', $this->getUniqueId());
        \common\models\UploadedFile::model()->deleteAll($criteria);

        parent::afterDelete();
    }

}