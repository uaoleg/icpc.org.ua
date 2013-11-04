<?php

namespace common\models\User;

/**
 * User's settings
 */
class Settings extends \common\ext\MongoDb\Document
{

    /**
     * User ID
     * @var string
     */
    public $userId;

    /**
     * News, Results, etc.
     * @var int
     */
    public $year;

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
            'userId'    => \yii::t('app', 'User ID'),
            'year'      => \yii::t('app', 'Year'),
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
            array('userId', 'required'),
            array('userId', 'unique'),
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'user.settings';
	}

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'userId' => array(
                'key' => array(
                    'userId' => \EMongoCriteria::SORT_ASC,
                ),
                'unique' => true,
            ),
        ));
    }

    /**
     * Before validate action
     *
     * @return bool
     */
    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) return false;

        // Convert MongoId to string
        $this->userId = (string)$this->userId;

        // Convert to int
        $this->year = (int)$this->year;

        return true;
    }

    /**
     * Before save action
     *
     * @return bool
     */
    protected function beforeSave()
    {
        if (!parent::beforeSave()) return false;

        // Check for changes
        $changes = $this->attributesChanges();
        if (!$changes['changed']) {
            return false;
        }

        return true;
    }

}