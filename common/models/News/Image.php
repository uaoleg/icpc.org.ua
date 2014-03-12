<?php
namespace common\models\News;

use common\models\UploadedFile;

/**
 * Image
 * @property-read UploadedFile $file
 */
class Image extends \common\ext\MongoDb\Document
{

    /**
     * ID of a news
     * @var string
     */
    public $newsId;

    /**
     * Image title
     * @var string
     */
    public $fileName;

    /**
     * ID of a user who downloads the image
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
     * This returns the name of the collection for this class
     * @return string
     */
    public function getCollectionName()
    {
        return 'news.images';
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
            'newsId'    => \yii::t('app', 'ID of the news'),
            'title'     => \yii::t('app', 'Image title'),
            'extension' => \yii::t('app', 'Image extension'),
        ));
    }

    /**
     * Define attribute rules
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('userId, fileName', 'required')
        ));
    }

    /**
     * After delete action
     */
    protected function afterDelete()
    {
        /**
         * Delete uploaded file of this image
         */
        $this->file->delete();

        parent::afterDelete();
    }


}