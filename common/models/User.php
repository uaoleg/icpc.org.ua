<?php

namespace common\models;

/**
 * User
 *
 * @property-read string        $firstName
 * @property-read string        $middleName
 * @property-read string        $lastName
 * @property-read School        $school
 * @property-read User\Settings $settings
 * @property-read User\Info     $info
 * @property-read User          $approver
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
     * First name in Ukrainian
     * @var string
     */
    public $firstNameUk;

    /**
     * Middle name in Ukrainian
     * @var string
     */
    public $middleNameUk;

    /**
     * Last name in Ukrainian
     * @var string
     */
    public $lastNameUk;

    /**
     * First name in English
     * @var string
     */
    public $firstNameEn;

    /**
     * Middle name in English
     * @var string
     */
    public $middleNameEn;

    /**
     * Last name in English
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
     * Is email confirmed
     * @var boolean
     */
    public $isEmailConfirmed = false;

    /**
     * Is approved student
     * @var boolean
     */
    public $isApprovedStudent = false;

    /**
     * Is approved coach
     * @var boolean
     */
    public $isApprovedCoach = false;

    /**
     * Is approved coordinator
     * @var boolean
     */
    public $isApprovedCoordinator = false;

    /**
     * User's school
     * @var School
     */
    protected $_school;

    /**
     * User's settings
     * @var User\Settings
     */
    protected $_settings;

    /**
     * User's additional info
     * @var User\Info
     */
    protected $_info;

    /**
     * Returns first name in appropriate language
     *
     * @return string
     */
    public function getFirstName()
    {
        switch ($this->useLanguage) {
            default:
            case 'uk':
                return $this->firstNameUk;
                break;
            case 'en':
                return (!empty($this->firstNameEn)) ? $this->firstNameEn : $this->firstNameUk;
                break;
        }
    }

    /**
     * Returns middle name in appropriate language
     *
     * @return string
     */
    public function getMiddleName()
    {
        switch ($this->useLanguage) {
            default:
            case 'uk':
                return $this->middleNameUk;
                break;
            case 'en':
                return (!empty($this->middleNameEn)) ? $this->middleNameEn : $this->middleNameUk;
                break;
        }
    }

    /**
     * Returns last name in appropriate language
     *
     * @return string
     */
    public function getLastName()
    {
        switch ($this->useLanguage) {
            default:
            case 'uk':
                return $this->lastNameUk;
                break;
            case 'en':
                return (!empty($this->lastNameEn)) ? $this->lastNameEn : $this->lastNameUk;
                break;
        }
    }

    /**
     * Returns user's school
     *
     * @return School
     */
    public function getSchool()
    {
        if ($this->_school === null) {
            $this->_school = School::model()->findByPk(new \MongoId($this->schoolId));
            if ($this->_school === null) {
                return new School();
            }
        }
        return $this->_school;
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

    /**
     * Returns user's additional info
     *
     * @return User\Info
     */
    public function getInfo()
    {
        if ($this->_info === null) {
            if ($this->useLanguage === 'en') {
                $lang = 'en';
            } else {
                $lang = 'uk';
            }
            if ($this->type === static::ROLE_STUDENT) {
                $this->_info = User\InfoStudent::model()->findByAttributes(array(
                    'userId' => (string)$this->_id,
                    'lang'   => $lang,
                ));
                if ($this->_info === null) {
                    $this->_info = new User\InfoStudent();
                    $this->_info->setAttributes(array(
                        'userId'    => (string)$this->_id,
                        'lang'      => $lang,
                    ), false);
                }
            } elseif ($this->type === static::ROLE_COACH) {
                $this->_info = User\InfoCoach::model()->findByAttributes(array(
                    'userId' => (string)$this->_id,
                    'lang'   => $lang,
                ));
                if ($this->_info === null) {
                    $this->_info = new User\InfoCoach();
                    $this->_info->setAttributes(array(
                        'userId'    => (string)$this->_id,
                        'lang'      => $lang,
                    ), false);
                }
            } else {
                $this->_info = User\Info::model()->findByAttributes(array(
                    'userId' => (string)$this->_id,
                    'lang'   => $lang,
                ));
                if ($this->_info === null) {
                    $this->_info = new User\Info();
                    $this->_info->setAttributes(array(
                        'userId'    => (string)$this->_id,
                        'lang'      => $lang,
                    ), false);
                }
            }
        }
        return $this->_info;
    }

    /**
     * Returns user who can approve this user's coach/coordinator status
     *
     * @return User
     */
    public function getApprover()
    {
        $key = 'approver';
        if (!$this->cache->get($key)) {
            $criteria = new \EMongoCriteria();
            // Get approver for coordinator
            if (!empty($this->coordinator) && !$this->isApprovedCoordinator) {
                switch ($this->coordinator) {
                    case static::ROLE_COORDINATOR_REGION:
                    case static::ROLE_COORDINATOR_UKRAINE:
                        $criteria
                            ->addCond('isApprovedCoordinator', '==', true)
                            ->addCond('coordinator', '==', static::ROLE_COORDINATOR_UKRAINE);
                        break;
                    case static::ROLE_COORDINATOR_STATE:
                        $schoolIds = School::model()->getCollection()->distinct('_id', array(
                            'region' => $this->school->region,
                        ));
                        $ids = array();
                        foreach ($schoolIds as $schoolId) {
                            $ids[] = (string)$schoolId;
                        }
                        $criteria
                            ->addCond('isApprovedCoordinator', '==', true)
                            ->addCond('coordinator', '==', static::ROLE_COORDINATOR_REGION)
                            ->addCond('schoolId', 'in', $ids);
                        break;
                }
            }

            // Get approver for coach
            elseif (($this->type === static::ROLE_COACH) && (!$this->isApprovedCoach)) {
                $schoolIds = School::model()->getCollection()->distinct('_id', array(
                    'region' => $this->school->region
                ));
                $ids = array();
                foreach ($schoolIds as $schoolId) {
                    $ids[] = (string)$schoolId;
                }
                $criteria
                    ->addCond('isApprovedCoordinator', '==', true)
                    ->addCond('coordinator', '==', static::ROLE_COORDINATOR_STATE)
                    ->addCond('schoolId', 'in', $ids);
            }
            $this->cache->set($key, User::model()->find($criteria), SECONDS_IN_HOUR);
        }
        return $this->cache->get($key);
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
            'firstName'         => \yii::t('app', 'First name'),
            'middleName'        => \yii::t('app', 'Middle name'),
            'lastName'          => \yii::t('app', 'Last name'),
            'firstNameUk'       => \yii::t('app', 'First name in Ukrainian'),
            'middleNameUk'      => \yii::t('app', 'Middle name in Ukrainian'),
            'lastNameUk'        => \yii::t('app', 'Last name in Ukrainian'),
            'firstNameEn'       => \yii::t('app', 'First name in English'),
            'middleNameEn'      => \yii::t('app', 'Middle name in English'),
            'lastNameEn'        => \yii::t('app', 'Last name in English'),
            'email'             => \yii::t('app', 'Email'),
            'hash'              => \yii::t('app', 'Password hash'),
            'type'              => \yii::t('app', 'Type'),
            'coordinator'       => \yii::t('app', 'Coordination type'),
            'schoolId'          => \yii::t('app', 'School'),
            'dateCreated'       => \yii::t('app', 'Registration date'),
            'isEmailConfirmed'  => \yii::t('app', 'Is email confirmed'),
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
            array('firstNameUk, middleName, lastNameUk', 'length', 'max' => 100),
            array('coordinator', User\Validator\Coordinator::className()),
            array('role', User\Validator\Role::className()),
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
        $this->isEmailConfirmed = (bool)$this->isEmailConfirmed;

        // Type
        if (!in_array($this->type, array(static::ROLE_STUDENT, static::ROLE_COACH))) {
            $this->type = null;
        }

        // Set created date
        if ($this->dateCreated == null) {
            $this->dateCreated = time();
        }

        return true;
    }

    /**
     * Before save action
     *
     * @return bool
     */
    protected function beforeSave()
    {
        // Revoke coordination roles if it was changed
        if ((!$this->getIsNewRecord()) && ($this->attributeHasChanged('coordinator'))) {
            $this->isApprovedCoordinator = false;
        }

        // Revoke coach roles if it was changed
        if ((!$this->getIsNewRecord()) && ($this->attributeHasChanged('type'))) {
            $this->isApprovedCoach = false;
        }

        return parent::beforeSave();
    }


    /**
     * After save action
     */
    protected function afterSave()
    {
        // If user changed any name, info in results and teams models should be updated
        $initialUser = new static();
        $initialUser->setAttributes($this->_initialAttributes, false);
        foreach (array('uk', 'en') as $lang) {

            // Check if name changed
            $initialName = \web\widgets\user\Name::create(array(
                'user' => $initialUser,
                'lang' => $lang,
            ), true);
            $currentName = \web\widgets\user\Name::create(array(
                'user' => $this,
                'lang' => $lang,
            ), true);
            if ($initialName === $currentName) {
                continue;
            }

            // Update results and teams
            $modifier = new \EMongoModifier();
            $modifier->addModifier('coachName' . ucfirst($lang), 'set', $currentName);
            $criteria = new \EMongoCriteria();
            $criteria->addCond('coachId', '==', (string)$this->_id);
            Result::model()->updateAll($modifier, $criteria);
            Team::model()->updateAll($modifier, $criteria);
        }

        // If any of isApproved properties is changed need to assign or revoke role
        if ($this->attributeHasChanged('isApprovedStudent')) {
            if ($this->isApprovedStudent) {
                if (!\yii::app()->authManager->checkAccess(User::ROLE_STUDENT, (string)$this->_id)) {
                    \yii::app()->authManager->assign(User::ROLE_STUDENT, (string)$this->_id);
                }
            } else {
                \yii::app()->authManager->revoke(User::ROLE_STUDENT, (string)$this->_id);
            }
        }
        if ($this->attributeHasChanged('isApprovedCoach')) {
            if ($this->isApprovedCoach) {
                if (!\yii::app()->authManager->checkAccess(User::ROLE_COACH, (string)$this->_id)) {
                    \yii::app()->authManager->assign(User::ROLE_COACH, (string)$this->_id);
                }
            } else {
                \yii::app()->authManager->revoke(User::ROLE_COACH, (string)$this->_id);
            }
        }
        if ($this->attributeHasChanged('isApprovedCoordinator')) {
            if ($this->isApprovedCoordinator) {
                if (!\yii::app()->authManager->checkAccess($this->coordinator, (string)$this->_id)) {
                    \yii::app()->authManager->assign($this->coordinator, (string)$this->_id);
                }
            } else {
                \yii::app()->authManager->revoke(User::ROLE_COORDINATOR_STATE, (string)$this->_id);
                \yii::app()->authManager->revoke(User::ROLE_COORDINATOR_REGION, (string)$this->_id);
                \yii::app()->authManager->revoke(User::ROLE_COORDINATOR_UKRAINE, (string)$this->_id);
            }
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
            $this->addError('passwordRepeat', \yii::t('app', '{attr} is not confirmed.', array(
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

    /**
     * After delete action
     */
    protected function afterDelete()
    {
        $userId = (string)$this->_id;
        $criteria = new \EMongoCriteria();
        $criteria->addCond('userId', '==', $userId);

        // Delete settings
        if (!$this->settings->isNewRecord) {
            $this->settings->delete();
        }

        // Delete additional info
        if (!$this->info->isNewRecord) {
            $this->info->delete();
        }

        // Delete teams where this user is coach
        $teamsToDelete = Team::model()->findAllByAttributes(array(
            'coachId' => $userId,
        ));
        foreach ($teamsToDelete as $team) {
            $team->delete();
        }

        // Remove user's ID from memberIds of teams user is in
        $teams = Team::model()->findAllByAttributes(array(
            'memberIds' => $userId,
        ));
        foreach ($teams as $team) {
            $team->scenario = Team::SC_USER_DELETING;
            $team->memberIds = array_diff($team->memberIds, (array)$userId);
            $team->save();
        }

        // Delete all question and answers related to this user
        Qa\Question::model()->deleteAll($criteria);
        Qa\Answer::model()->deleteAll($criteria);

        parent::afterDelete();
    }

}
