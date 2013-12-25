<?php

namespace common\models\Qa;

/**
 * Question tag
 * @property-read int $questionCount
 */
class Tag extends \common\ext\MongoDb\Document
{

    /**
     * Tag name
     * @var string
     */
    public $name;

    /**
     * Tag description
     * @var string
     */
    public $desc;

    /**
     * Date created
     * @var int
     */
    public $dateCreated;

    /**
     * Get number of questions with this tag
     * @return int
     */
    public function getQuestionCount() {
        return Question::model()->countByAttributes(array(
            'tagList' => $this->name
        ));
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
            'name'          => \yii::t('app', 'Name'),
            'desc'          => \yii::t('app', 'Desc'),
            'dateCreated'   => \yii::t('app', 'Registration date'),
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
            array('name, dateCreated', 'required'),
            array('name', 'unique'),
            array('name', 'length', 'max' => 100),
            array('desc', 'length', 'max' => 5000),
        ));
    }

	/**
	 * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'qa.tag';
	}

    /**
     * List of collection indexes
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
        ));
    }

    /**
     * Before validate action
     *
     * @return bool
     */
    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        // Convert to string
        $this->name = trim(mb_strtolower($this->name));

        // Set created date
        if ($this->dateCreated == null) {
            $this->dateCreated = time();
        }

        return true;
    }

    protected function afterDelete()
    {
        // After tag is deleted we need to delete it from tagLists of questions
        $questions = Question::model()->findAllByAttributes(array(
            'tagList' => mb_strtolower($this->name)
        ));
        foreach ($questions as $question) {
            $question->scenario = Question::SC_AFTER_DELETE_TAG;
            $question->tagList = array_diff($question->tagList, (array)$this->name);
            $question->save();
        }

        parent::afterDelete();
    }


}