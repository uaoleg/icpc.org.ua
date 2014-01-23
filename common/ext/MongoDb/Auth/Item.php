<?php

namespace common\ext\MongoDb\Auth;

/**
 * MongoDB Auth Item
 */
class Item extends \common\ext\MongoDb\Document
{

    /**
     * Type of auth item
     * @var int
     * @see \CAuthItem::TYPE_
     */
	public $type;

    /**
     * Name
     * @var string
     */
	public $name;

    /**
     * Description
     * @var string
     */
	public $description;

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
     * List of children
     * @var array
     */
    public $children = array();

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
            'type'          => \yii::t('app', 'Type of auth item'),
			'name'          => \yii::t('app', 'Name'),
            'description'   => \yii::t('app', 'Description'),
            'bizRule'       => \yii::t('app', 'Business rule'),
            'data'          => \yii::t('app', 'Additional data'),
            'children'      => \yii::t('app', 'List of children'),
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
            array('type, name', 'required'),
            array('name', 'unique'),
		));
	}

	/**
	 * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'auth.item';
	}

    /**
     * List of collection inexes
     *
     * @return array
     */
    public function indexes()
	{
		return array_merge(parent::indexes(), array(
            'name' => array(
                'key' => array(
                    'name' => \EMongoCriteria::SORT_ASC,
                ),
                'unique' => true,
            ),
            'type' => array(
                'key' => array(
                    'type' => \EMongoCriteria::SORT_ASC,
                ),
            ),
        ));
	}

    /**
     * Before validate action
     *
     * @return boolean
     */
    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) return false;

        // Make all roles lower case
        if ($this->type == \CAuthItem::TYPE_ROLE) {
            $this->name = strtolower($this->name);
        }

        // Check additional data to be array
        if (!is_array($this->data)) {
            $this->data = array();
        }

        // Check list of children to be array and unique
        if (!is_array($this->children)) {
            $this->children = array();
        }
        $this->children = array_unique($this->children);

        // Check that children do not contain the name
        if (in_array($this->name, $this->children)) {
            $this->addError('children', \yii::t('app', 'Children can not containt item name.'));
            return false;
        }

        return true;
    }

    /**
     * Deletes the row corresponding to this EMongoDocument.
     *
     * @return bool
     */
    public function delete()
    {
        throw new \CException('app', 'Use Manager::removeAuthItem() instead.');
    }

}
