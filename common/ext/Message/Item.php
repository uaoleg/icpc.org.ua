<?php

namespace common\ext\Message;

/**
 * Translation message item
 */
class Item extends \common\ext\MongoDb\Document
{
    /**
     * Category name for js files messages
     */
    CONST JS_CATEGORY = 'appjs';

    /**
     * Translation category
     * @var string
     */
    public $category;

    /**
     * Language
     * @var string
     */
    public $language;

    /**
     * Source message (constant)
     * @var string
     */
    public $message;

    /**
     * Translation
     * @var string
     */
    public $translation = '';

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
            'category'      => \yii::t('app', 'Category'),
            'language'      => \yii::t('app', 'Language'),
            'message'       => \yii::t('app', 'Message'),
            'translation'   => \yii::t('app', 'Translation'),
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
            array('category, language, message', 'required'),
        ));
    }

	/**
	 * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'translation';
	}

    /**
     * List of collection inexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'category_language_message' => array(
                'key' => array(
                    'category' => \EMongoCriteria::SORT_ASC,
                    'language' => \EMongoCriteria::SORT_ASC,
                    'message'  => \EMongoCriteria::SORT_ASC,
                ),
                'unique' => true,
            ),
        ));
    }


}