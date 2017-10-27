<?php

namespace common\components\Message;

use \common\models\BaseActiveRecord;

/**
 * Translation message item
 *
 * @property string $category
 * @property string $language
 * @property string $message
 * @property string $translation
 */
class Item extends BaseActiveRecord
{

    /**
     * Category name for js files messages
     */
    CONST JS_CATEGORY = 'appjs';

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%translation}}';
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'category'      => \yii::t('app', 'Category'),
            'language'      => \yii::t('app', 'Language'),
            'message'       => \yii::t('app', 'Message'),
            'translation'   => \yii::t('app', 'Translation'),
        ]);
    }

    /**
     * Define attribute rules
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['category', 'language', 'message'], 'required'],
            ['translation', 'default', 'value' => ''],
        ]);
    }

}
