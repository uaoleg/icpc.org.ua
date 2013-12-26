<?php

namespace common\models\Qa;

use \common\models\User;

/**
 * Answer
 *
 * @property-read User      $user
 * @property-read Question  $question
 */
class Answer extends \common\ext\MongoDb\Document
{

    /**
     * User ID
     * @var string
     */
    public $userId;

    /**
     * Question ID
     * @var string
     */
    public $questionId;

    /**
     * Content
     * @var string
     */
    public $content;

    /**
     * Date created
     * @var int
     */
    public $dateCreated;

    /**
     * Answer author
     * @var User
     */
    protected $_user;

    /**
     * Related question
     * @var Question
     */
    protected $_question;

    /**
     * Returns answer author
     *
     * @return Question
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::model()->findByPk(new \MongoId($this->userId));
        }
        return $this->_user;
    }

    /**
     * Returns related question
     *
     * @return Question
     */
    public function getQuestion()
    {
        if ($this->_question === null) {
            $this->_question = Question::model()->findByPk(new \MongoId($this->questionId));
        }
        return $this->_question;
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
            'userId'        => \yii::t('app', 'User ID'),
            'questionId'    => \yii::t('app', 'Question ID'),
            'content'       => \yii::t('app', 'Content'),
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
            array('userId, questionId, content, dateCreated', 'required'),
            array('content', 'length', 'max' => 5000),
        ));
    }

	/**
	 * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'qa.answer';
	}

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'userId_dateCreated' => array(
                'key' => array(
                    'userId'        => \EMongoCriteria::SORT_ASC,
                    'dateCreated'   => \EMongoCriteria::SORT_DESC,
                ),
            ),
            'questionId_dateCreated' => array(
                'key' => array(
                    'questionId'    => \EMongoCriteria::SORT_ASC,
                    'dateCreated'   => \EMongoCriteria::SORT_DESC,
                ),
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
        $this->userId = (string)$this->userId;
        $this->questionId = (string)$this->questionId;

        // Set created date
        if ($this->dateCreated == null) {
            $this->dateCreated = time();
        }

        return true;
    }

    /**
     * After save action
     */
    protected function afterSave()
    {
        // Recount answers for the related question
        if ($this->_isFirstTimeSaved) {
            $this->question->answerCount = $this->countByAttributes(array(
                'questionId' => $this->questionId,
            ));
            $this->question->save();
        }

        parent::afterSave();
    }

}