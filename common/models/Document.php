<?php

namespace common\models;

/**
 * Document
 *
 * @property string $title
 * @property string $desc
 * @property string $type
 * @property string $fileExt
 * @property bool   $isPublished
 * @property string $content
 * @property string $timeCreated
 * @property string $timeUpdated
 */
class Document extends BaseActiveRecord
{

    /**
     * Available doc types
     */
    const TYPE_GUIDANCE     = 'guidance';
    const TYPE_REGULATIONS  = 'regulations';

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%document}}';
    }

    /**
     * Returns a list of behaviors that this component should behave as
     * @return array
     */
    public function behaviors()
    {
        return [
            $this->behaviorTimestamp(),
        ];
    }

    /**
     * Returns the attribute labels.
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
            'timeCreated'   => \yii::t('app', 'Registration date'),
        ));
    }

    /**
     * Returns the constant labels
     * @return string[]
     */
    public static function constantLabels()
    {
        return [
            static::TYPE_GUIDANCE       => \yii::t('app', 'Guidance'),
            static::TYPE_REGULATIONS    => \yii::t('app', 'Regulations'),
        ];
    }

    /**
     * Define attribute rules
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title', 'type', 'fileExt'], 'required'],

            ['title', 'string', 'max' => 300],

            ['desc', 'string', 'max' => 1000],

            ['isPublished', 'boolean'],
            ['isPublished', 'default', 'value' => false],

            ['content', 'safe'],
        ]);
    }

}
