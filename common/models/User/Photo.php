<?php

namespace common\models\User;

use \common\models\UploadedFile;

class Photo extends \common\ext\MongoDb\Document
{

    /**
     * Image title
     * @var string
     */
    public $fileName;

    /**
     * ID of a user
     * @var string
     */
    public $userId;

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
            'fileName' => \yii::t('app', 'Image title'),
            'userId'   => \yii::t('app', 'ID of a user')
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
            array('userId, fileName', 'required')
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'user.photo';
    }

    /**
     * Before validate action
     *
     * @return bool
     */
    protected function beforeValidate()
    {
        // Convert MongoId to string
        $this->userId = (string)$this->userId;

        return parent::beforeValidate();
    }

}
