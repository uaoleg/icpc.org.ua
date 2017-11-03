<?php

namespace common\models;

use \common\models\BaseActiveRecord;
use \common\models\News\Image;

/**
 * News item
 *
 * @property int    $commonId
 * @property string $lang
 * @property string $title
 * @property string $content
 * @property bool   $isPublished
 * @property string $geo
 * @property int    $yearCreated
 * @property int    $timeCreated
 * @property int    $timeUpdated
 */
class News extends BaseActiveRecord
{

    const MAX_IMAGES_COUNT = 20;

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%news}}';
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
            'commonId'      => \yii::t('app', 'Common ID'),
            'lang'          => \yii::t('app', 'Language'),
            'title'         => \yii::t('app', 'Title'),
            'content'       => \yii::t('app', 'Content'),
            'isPublished'   => \yii::t('app', 'Is published'),
            'geo'           => \yii::t('app', 'Geo'),
            'yearCreated'   => \yii::t('app', 'Year date'),
            'timeCreated'   => \yii::t('app', 'Date date'),
        ));
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['lang', 'title', 'content', 'geo', 'yearCreated'], 'required'],

            ['title', 'string', 'max' => 300],

            ['content', 'string', 'max' => 5000],

            ['isPublished', 'boolean'],
            ['isPublished', 'default', 'value' => false],
        ]);
    }

    /**
     * Get images ids of the news
     * @return array
     */
    public function getImagesIds()
    {
        if (empty($this->commonId)) {
            $images = Image::findAll([
                'newsId'    => null,
                'userId'    => \yii::$app->user->id,
            ]);
        } else {
            $images = Image::findAll(['newsId' => $this->commonId]);
        }

        $imagesIds = array();
        foreach ($images as $image) {
            $imagesIds[] = $image->id;
        }

        return $imagesIds;
    }

    /**
     * Before save action
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Update year
        $this->yearCreated = (int)date('Y', $this->timeCreated);

        return true;
    }

    /**
     * After save action
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        // Set common ID
        if (empty($this->commonId)) {
            $this->commonId = $this->id;
            $this->save();
        }

        // If title or content are changed need to add entry to news revisions
        if ($this->isAttributeChangedAfterSave('title', $changedAttributes) || $this->isAttributeChangedAfterSave('content', $changedAttributes)) {
            $revision = new News\Revision();
            $revision->setAttributes(array(
                'newsId'         => $this->id,
                'newsAttributes' => $this->getAttributes(),
            ), false);
            $revision->save();
        }

        // Add entry to news publish log
        if ($this->isAttributeChangedAfterSave('isPublished', $changedAttributes)) {
            $revision = News\Revision::find()
                ->orderBy('timestamp DESC')
                ->one()
            ;
            $publishLogEntry = new News\PublishLog([
                'newsId'      => $this->id,
                'revisionId'  => $revision->id,
                'userId'      => $revision->userId,
                'isPublished' => $this->isPublished,
            ]);
            $publishLogEntry->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }

}
