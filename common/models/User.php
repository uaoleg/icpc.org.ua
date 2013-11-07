<?php

namespace common\models;

/**
 * User
 *
 * @property-read bool                            $isApprovedCoach
 * @property-read bool                            $isApprovedCoordinator
 * @property-read string                          $firstName
 * @property-read string                          $middleName
 * @property-read string                          $lastName
 * @property-read User\InfoCoach|User\InfoStudent $info
 * @property-read User\Settings                   $settings
 */
class User extends \common\ext\MongoDb\Document
{

    /**
     * List of user roles
     */
    const ROLE_GUEST                = 'guest';
    const ROLE_USER                 = 'user';
    const ROLE_STUDENT              = 'student';
    const ROLE_COACH                = 'coach';
    const ROLE_COORDINATOR_STATE    = 'coordinator_state';
    const ROLE_COORDINATOR_REGION   = 'coordinator_region';
    const ROLE_COORDINATOR_UKRAINE  = 'coordinator_ukraine';
    const ROLE_ADMIN                = 'admin';

    /**
     * First name in ukrainian
     * @var string
     */
    public $firstNameUk;

    /**
     * Middle name in ukrainian
     * @var string
     */
    public $middleNameUk;

    /**
     * Last name in ukrainian
     * @var string
     */
    public $lastNameUk;

    /**
     * First name in english
     * @var string
     */
    public $firstNameEn;

    /**
     * Middle name in english
     * @var string
     */
    public $middleNameEn;

    /**
     * Last name in english
     * @var string
     */
    public $lastNameEn;

    /**
     * Contact email
     * @var string
     */
    public $email;

    /**
     * Hash of the password.
     * Don't set it directly!!!
     * @see setPassword()
     * @var string
     */
    public $hash;

    /**
     * User type (static::ROLE_STUDENT or static::ROLE_COACH only)
     * @var string
     */
    public $type;

    /**
     * Coordination type (static::ROLE_COORDINATOR_)
     * @var string
     */
    public $coordinator;

    /**
     * School ID
     */
    public $schoolId;

    /**
     * Date created
     * @var int
     */
    public $dateCreated;

    /**
     * User's settings
     * @var User\Settings
     */
    protected $_settings;

    /**
     * User's additional info
     * @var User\InfoCoach|User\InfoStudent
     */
    protected $_info;

    /**
     * Returns first name in appropriate language
     * @return null|string
     */
    public function getFirstName($lang = null)
    {
        $lang = (isset($lang)) ? \yii::app()->getLanguage() : $lang;
        switch ($lang) {
            default:
            case 'uk':
                return $this->firstNameUk;
                break;
            case 'en':
                return $this->firstNameEn;
                break;
        }
    }

    /**
     * Returns middle name in appropriate language
     * @return null|string
     */
    public function getMiddleName($lang = null)
    {
        $lang = (isset($lang)) ? \yii::app()->getLanguage() : $lang;
        switch ($lang) {
            default:
            case 'uk':
                return $this->middleNameUk;
                break;
            case 'en':
                return $this->middleNameEn;
                break;
        }
    }

    /**
     * Returns last name in appropriate language
     * @return null|string
     */
    public function getLastName($lang = null)
    {
        $lang = (isset($lang)) ? \yii::app()->getLanguage() : $lang;
        switch ($lang) {
            default:
            case 'uk':
                return $this->lastNameUk;
                break;
            case 'en':
                return $this->lastNameEn;
                break;
        }
    }

    /**
     * Returns whether coach role is approved
     *
     * @return bool
     */
    public function getIsApprovedCoach()
    {
        return \yii::app()->authManager->checkAccess(static::ROLE_COACH, $this->_id);
    }

    /**
     * Returns whether coordinator role is approved
     *
     * @return bool
     */
    public function getIsApprovedCoordinator()
    {
        return \yii::app()->authManager->checkAccess($this->coordinator, $this->_id);
    }

    /**
     * Returns user's settings
     *
     * @return User\Settings
     */
    public function getSettings()
    {
        if ($this->_settings === null) {
            $this->_settings = User\Settings::model()->findByAttributes(array(
                'userId' => (string)$this->_id,
            ));
            if ($this->_settings === null) {
                $this->_settings = new User\Settings();
                $this->_settings->userId = (string)$this->_id;
            }
        }
        return $this->_settings;
    }

    public function getInfo($lang = null)
    {
        if (!isset($lang)) {
            $lang = \yii::app()->language;
        }
        if (!isset($this->_info)) {
            if ($this->type === 'student') {
                $this->_info = User\InfoStudent::model()->findByAttributes(array(
                    'userId' => (string)$this->_id,
                    'lang'   => $lang
                ));
                if (!isset($this->_info)) {
                    $this->_info = new User\InfoStudent();
                    $this->_info->userId = (string)$this->_id;
                }
            } elseif ($this->type === 'coach') {
                $this->_info = User\InfoCoach::model()->findByAttributes(array(
                    'userId' => (string)$this->_id,
                    'lang'   => $lang
                ));
                if (!isset($this->_info)) {
                    $this->_info = new User\InfoCoach();
                    $this->_info->userId = (string)$this->_id;
                }
            }
        }
        return $this->_info;
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
            'firstName'      => \yii::t('app', 'First name'),
            'middleName'     => \yii::t('app', 'First name'),
            'lastName'       => \yii::t('app', 'First name'),
            'firstNameUk'    => \yii::t('app', 'First name in ukrainian'),
            'middleNameUk'   => \yii::t('app', 'Middle name in ukranian'),
            'lastNameUk'     => \yii::t('app', 'Last name in ukrainian'),
            'firstNameEn'    => \yii::t('app', 'First name in english'),
            'middleNameEn'   => \yii::t('app', 'Middle name in english'),
            'lastNameEn'     => \yii::t('app', 'Last name in english'),
            'email'          => \yii::t('app', 'Email'),
            'hash'           => \yii::t('app', 'Password hash'),
            'type'           => \yii::t('app', 'Type'),
            'coordinator'    => \yii::t('app', 'Coordination type'),
            'schoolId'       => \yii::t('app', 'School'),
            'dateCreated'    => \yii::t('app', 'Registration date'),
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
            array('firstNameUk, middleNameUk, lastNameUk, email, schoolId, dateCreated', 'required'),
            array('email', 'email'),
            array('email', 'unique'),
            array('firstName, lastName', 'length', 'max' => 100),
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'user';
	}

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'email' => array(
                'key' => array(
                    'email' => \EMongoCriteria::SORT_ASC,
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

        // Email
        $this->email = mb_strtolower($this->email);

        // Type
        if (!in_array($this->type, array(static::ROLE_STUDENT, static::ROLE_COACH))) {
            $this->type = null;
        }

        // Coordinator
        if (empty($this->coordinator)) {
            $this->coordinator = null;
        } elseif (!in_array($this->coordinator, $this->getConstantList('ROLE_COORDINATOR_'))) {
            $this->addError('coordinator', \yii::t('app', 'Unknown coordinator type.'));
        } elseif ($this->type === static::ROLE_STUDENT) {
            $this->addError('coordinator', \yii::t('app', 'Student can not be coordinator.'));
        }

        // Check that either type or coordinator is filled
        if ((empty($this->type)) && (empty($this->coordinator))) {
            $this->addError('role', \yii::t('app', 'User should have some role.'));
        }

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
        // Revoke coordination roles if it was changed
        if ((!$this->_isFirstTimeSaved) && (($this->attributeHasChanged('coordinator')) || ($this->attributeHasChanged('type')))) {
            \yii::app()->authManager->revoke(static::ROLE_COORDINATOR_STATE, $this->_id);
            \yii::app()->authManager->revoke(static::ROLE_COORDINATOR_REGION, $this->_id);
            \yii::app()->authManager->revoke(static::ROLE_COORDINATOR_UKRAINE, $this->_id);
        }

        parent::afterSave();
    }

    /**
     * Set user's password
     *
     * @param string $password
     * @param string $passwordRepeat
     */
    public function setPassword($password, $passwordRepeat)
    {
        // Clear all password errors
        $this->clearErrors('password');

        // Validate max length
        $maxLength = 255;
        if (strlen($password) > $maxLength) {
            $this->addError('password', \yii::t('app', '{attr} length should be less or equal than {val}.', array(
                '{attr}' => $this->getAttributeLabel('password'),
                '{val}'  => $maxLength,
            )));
        }

        // Check passwords to be equal
        if ($password != $passwordRepeat) {
            $this->addError('password', \yii::t('app', '{attr} is not confirmed.', array(
                '{attr}' => $this->getAttributeLabel('password'),
            )));
        }

        // Validate length
        $minLength = 6;
        if (strlen($password) < $minLength) {
            $this->addError('password', \yii::t('app', '{attr} length should be greater or equal than {val}.', array(
                '{attr}' => $this->getAttributeLabel('password'),
                '{val}'  => $minLength,
            )));
        }

        // Set password hash if password is valid
        if (!$this->hasErrors('password')) {
            $this->hash = crypt($password, '$6$rounds=5000$jIJM938Jwlfk)394kKkfweofk$');
        }
    }

    /**
     * Check inputed password
     *
     * @param string $password
     * @return bool
     */
    public function checkPassword($password)
    {
        return (crypt($password, $this->hash) === $this->hash);
    }

}