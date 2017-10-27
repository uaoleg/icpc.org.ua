<?php

namespace common\models;

class UploadedFile extends BaseActiveRecord
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
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%uploaded_file}}';
    }

    /**
     * Returns the attribute labels.
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