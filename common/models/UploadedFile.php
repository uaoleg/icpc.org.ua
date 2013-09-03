<?php

namespace common\models;

class UploadedFile extends \common\ext\MongoDb\GridFS
{

    /**
     * File unique ID
     * @var string
     */
    public $uniqueId;

    /**
     * Upload is completed
     * @var bool
     */
    public $uploadCompleted = false;

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
            'uniqueId'          => \yii::t('app', 'File unique ID'),
            'uploadCompleted'   => \yii::t('app', 'Upload is completed'),
        ));
    }

	/**
	 * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'uploadedFile';
	}

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'uniqueId' => array(
                'key' => array(
                    'uniqueId' => \EMongoCriteria::SORT_ASC,
                )
            ),
        ));
    }

    /**
     * Returns short file name (not file path)
     *
     * @return string
     */
    public function getShortName()
    {
        $name = substr($this->filename, strrpos($this->filename, '/') + 1);
        return $name;
    }

}