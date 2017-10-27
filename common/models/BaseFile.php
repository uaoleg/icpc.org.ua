<?php

namespace common\models;

/**
 * Base file implementation
 *
 * @property string $bucket AmazonS3 bucket
 * @property string $name   Original file name
 * @property int    $size   File size in bytes
 * @property int    $timeCreated
 * @property int    $timeUpdated
 *
 * @property-read string $path
 * @property-read string $url
 */
abstract class BaseFile extends BaseActiveRecord
{

    /**
     * Returns a list of behaviors that this component should behave as
     * @return array
     */
    public function behaviors()
    {
        return [
            static::behaviorTimestamp(),
        ];
    }

    /**
     * Returns the validation rules for attributes
     * @return array
     */
    public function rules()
    {
        return [
            ['bucket', 'required'],
            [['name', 'size'], 'safe'],
        ];
    }

    /**
     * Append relations
     * @return array
     */
    public function fields()
    {
        $additionalFields = ['url'];
        return \yii\helpers\ArrayHelper::merge(parent::fields(), array_combine($additionalFields, $additionalFields));
    }

    /**
     * After delete action
     */
    public function afterDelete()
    {
        // Remove from AmazonS3
        \yii::$app->amazonS3->delete($this->path, $this->bucket);

        parent::afterDelete();
    }

    /**
     * Returns file path
     * @return string
     */
    public function getPath()
    {
        $info = pathinfo($this->name);
        $ext = isset($info['extension'])
            ? '.' . $info['extension']
            : '';
        return $this->id . $ext;
    }

    /**
     * Returns file URL
     * @return string
     */
    public function getUrl()
    {
        $url = "https://s3-eu-west-1.amazonaws.com/{$this->bucket}/{$this->path}";
        return $url;
    }

}
