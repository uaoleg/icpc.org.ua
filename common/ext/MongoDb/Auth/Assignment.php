<?php

namespace common\ext\MongoDb\Auth;

/**
 * MongoDB Auth Assignment
 */
class Assignment extends \common\ext\MongoDb\Document
{

    /**
     * Item name
     * @var string
     */
	public $itemName;

    /**
     * User ID
     * @var string
     */
    public $userId;

    /**
     * Business rule
     * @var string
     */
	public $bizRule;

    /**
     * Additional data
     * @var array
     */
	public $data = array();

    /**
     * Redefine parent property
     * @var bool
     */
    protected $_saveToStorageOnDelete = false;

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
			'itemName'  => \yii::t('app', 'Item name'),
            'userId'    => \yii::t('app', 'User ID'),
            'bizRule'   => \yii::t('app', 'Business rule'),
            'data'      => \yii::t('app', 'Additional data'),
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
            array('itemName, userId', 'required'),
		));
	}

	/**
	 * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'auth.assignment';
	}

    /**
     * List of collection inexes
     *
     * @return array
     */
    public function indexes()
	{
		return array_merge(parent::indexes(), array(
            'userId_itemName' => array(
                'key' => array(
                    'userId'    => \EMongoCriteria::SORT_ASC,
                    'itemName'  => \EMongoCriteria::SORT_ASC,
                ),
                'unique' => true,
            ),
            'itemName' => array(
                'key' => array(
                    'itemName'  => \EMongoCriteria::SORT_ASC,
                ),
            ),
        ));
	}

}
