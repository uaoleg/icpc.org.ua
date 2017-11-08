<?php

namespace common\models;

/**
 * User
 *
 * @property string $type
 * @property string $coordinator
 * @property int    $schoolId
 * @property bool   $isEmailConfirmed
 * @property bool   $isApprovedStudent
 * @property bool   $isApprovedCoach
 * @property bool   $isApprovedCoordinator
 *
 * @property-read string        $firstName
 * @property-read string        $middleName
 * @property-read string        $lastName
 * @property-read School        $school
 * @property-read User\Settings $settings
 * @property-read User\Info     $info
 * @property-read User          $approver
 * @property-read User\Photo    $photo
 */
class User extends Person implements \yii\web\IdentityInterface
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
     * User's additional info
     * @var User\Info
     */
    protected $_info;

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Returns the attribute labels.
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
            'passwordHash'      => \yii::t('app', 'Password hash'),
            'type'              => \yii::t('app', 'Type'),
            'coordinator'       => \yii::t('app', 'Coordination type'),
            'schoolId'          => \yii::t('app', 'School'),
            'timeCreated'       => \yii::t('app', 'Registration date'),
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
        return array_merge(parent::rules(), [

            [['firstNameUk', 'middleNameUk', 'lastNameUk', 'email', 'schoolId'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            [['firstNameUk', 'middleName', 'lastNameUk'], 'string', 'max' => 100],

            ['coordinator', 'in', 'range' => $this->getConstants('ROLE_COORDINATOR_')],

            [['isEmailConfirmed', 'isApprovedStudent', 'isApprovedCoach', 'isApprovedCoordinator'], 'boolean'],
            [['isEmailConfirmed', 'isApprovedStudent', 'isApprovedCoach', 'isApprovedCoordinator'], 'default', 'value' => false],

        ]);
    }

    /**
     * Before validate action
     * @return bool
     */
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if (($this->type === static::ROLE_STUDENT) && (!empty($this->coordinator))) {
            $this->addError('type', \yii::t('app', 'Student cannot be coordinator.'));
        }

        if ((empty($this->type)) && (empty($this->coordinator))) {
            $this->addError('type', \yii::t('app', 'User should have some role.'));
        }

        return !$this->hasErrors();
    }

    /**
     * Before save action
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        // Email to lower case
        $this->email = mb_strtolower($this->email);

        // Revoke coordination roles if it was changed
        if ((!$this->getIsNewRecord()) && ($this->isAttributeChanged('coordinator'))) {
            $this->isApprovedCoordinator = false;
        }

        // Revoke coach roles if it was changed
        if ((!$this->getIsNewRecord()) && ($this->isAttributeChanged('type'))) {
            $this->isApprovedCoach = false;
        }

        // Populate name tags
        $this->populateNameTags();

        return parent::beforeSave($insert);
    }


    /**
     * After save action
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        // If any of isApproved properties is changed need to assign or revoke role
        if ($this->isAttributeChangedAfterSave('isApprovedStudent', $changedAttributes)) {
            if ($this->isApprovedStudent) {
                if (!\yii::$app->authManager->checkAccess($this->id, User::ROLE_STUDENT)) {
                    \yii::$app->authManager->assign(User::ROLE_STUDENT, $this->id);
                }
            } else {
                \yii::$app->authManager->revoke(User::ROLE_STUDENT, $this->id);
            }
        }
        if ($this->isAttributeChangedAfterSave('isApprovedCoach', $changedAttributes)) {
            if ($this->isApprovedCoach) {
                if (!\yii::$app->authManager->checkAccess($this->id, User::ROLE_COACH)) {
                    \yii::$app->authManager->assign(User::ROLE_COACH, $this->id);
                }
            } else {
                \yii::$app->authManager->revoke(User::ROLE_COACH, $this->id);
            }
        }
        if ($this->isAttributeChangedAfterSave('isApprovedCoordinator', $changedAttributes)) {
            if ($this->isApprovedCoordinator) {
                if (!\yii::$app->authManager->checkAccess($this->id, $this->coordinator)) {
                    \yii::$app->authManager->assign($this->coordinator, $this->id);
                }
            } else {
                \yii::$app->authManager->revoke(User::ROLE_COORDINATOR_STATE, $this->id);
                \yii::$app->authManager->revoke(User::ROLE_COORDINATOR_REGION, $this->id);
                \yii::$app->authManager->revoke(User::ROLE_COORDINATOR_UKRAINE, $this->id);
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Returns user's school
     * @return School
     */
    public function getSchool()
    {
        $school = $this->hasOne(School::class, ['id' => 'schoolId'])->one();
        if ($school === null) {
            $school = new School();
        }
        return $school;
    }

    /**
     * Returns user's settings
     * @return User\Settings
     */
    public function getSettings()
    {
        $settings = $this->hasOne(User\Settings::class, ['userId' => 'id'])->one();
        if ($settings === null) {
            $settings = new User\Settings;
        }
        return $settings;
    }

    /**
     * Returns user's additional info
     * @return User\Info
     */
    public function getInfo()
    {
        if ($this->_info === null) {
            switch (static::$useLanguage) {
                case 'en':
                case 'uk':
                    $lang = static::$useLanguage;
                    break;
                default:
                    $lang = 'uk';
                    break;
            }
            if ($this->type === static::ROLE_STUDENT) {
                $this->_info = User\InfoStudent::findOne([
                    'userId' => $this->id,
                    'lang'   => $lang,
                ]);
                if ($this->_info === null) {
                    $this->_info = new User\InfoStudent();
                    $this->_info->setAttributes(array(
                        'userId'    => $this->id,
                        'lang'      => $lang,
                    ), false);
                }
            } elseif ($this->type === static::ROLE_COACH) {
                $this->_info = User\InfoCoach::findOne([
                    'userId' => $this->id,
                    'lang'   => $lang,
                ]);
                if ($this->_info === null) {
                    $this->_info = new User\InfoCoach();
                    $this->_info->setAttributes(array(
                        'userId'    => $this->id,
                        'lang'      => $lang,
                    ), false);
                }
            } else {
                $this->_info = null;
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

            // Get approver for coordinator
            if (!empty($this->coordinator) && !$this->isApprovedCoordinator) {

                switch ($this->coordinator) {
                    case static::ROLE_COORDINATOR_REGION:
                    case static::ROLE_COORDINATOR_UKRAINE:
                        $approver = User::findOne([
                            'isApprovedCoordinator' => true,
                            'coordinator'           => static::ROLE_COORDINATOR_UKRAINE,
                        ]);
                        break;
                    case static::ROLE_COORDINATOR_STATE:
                        $approver = User::find()
                            ->alias('user')
                            ->innerJoin(
                                ['school' => School::tableName()],
                                'school.id = user.schoolId AND school.region = :region',
                                [':region' => $this->school->region]
                            )
                            ->andWhere([
                                'isApprovedCoordinator' => true,
                                'coordinator'           => static::ROLE_COORDINATOR_REGION,
                            ])
                            ->one()
                        ;
                        break;
                }
            }

            // Get approver for coach
            elseif (($this->type === static::ROLE_COACH) && (!$this->isApprovedCoach)) {
                $approver = User::find()
                    ->alias('user')
                    ->innerJoin(
                        ['school' => School::tableName()],
                        'school.id = user.schoolId AND school.state = :state',
                        [':state' => $this->school->state]
                    )
                    ->andWhere([
                        'isApprovedCoordinator' => true,
                        'coordinator'           => static::ROLE_COORDINATOR_STATE,
                    ])
                    ->one()
                ;

                // If there is no state coordinator than try regional one
                if ($approver === null) {
                    $approver = User::find()
                        ->alias('user')
                        ->innerJoin(
                            ['school' => School::tableName()],
                            'school.id = user.schoolId AND school.region = :region',
                            [':region' => $this->school->region]
                        )
                        ->andWhere([
                            'isApprovedCoordinator' => true,
                            'coordinator'           => static::ROLE_COORDINATOR_REGION,
                        ])
                        ->one()
                    ;
                }
            }

            // Otherwise there is no approver
            else {
                $approver = null;
            }

            $this->cache->set($key, $approver, SECONDS_IN_HOUR);
        }
        return $this->cache->get($key);
    }

    /**
     * Returns user's photo
     * @return \yii\db\ActiveQuery
     */
    public function getPhoto()
    {
        return $this->hasOne(User\Photo::class, ['userId' => 'id']);
    }

    /**
     * Implode all name fields into one field
     */
    public function populateNameTags()
    {
        $parts = array_filter([
            $this->firstNameUk,
            $this->middleNameUk,
            $this->lastNameUk,
            $this->firstNameEn,
            $this->middleNameEn,
            $this->lastNameEn,
        ]);
        sort($parts);
        $this->nameTags = mb_strtolower(implode(' ', $parts));
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Get access token
        $parsed = User\AccessToken\RestApi::parse($token);
        $accessToken = User\AccessToken\RestApi::findOne([
            'firmHash'  => $parsed->firmHash,
            'token'     => $parsed->token,
        ]);

        // Get user
        if ($accessToken) {
            $user = static::findOne($accessToken->userId);
        } else {
            $user = null;
        }
        return $user;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'passwordResetToken' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = \yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $isValid = \yii::$app->security->validatePassword($password, $this->passwordHash);
        if (!$isValid) {
            $this->addError('password', \yii::t('app', 'Неверный пароль.'));
        }
        return $isValid;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = \yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = \yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->passwordResetToken = null;
    }

    /**
     * Returns email token (is used for validation)
     * @return string
     */
    public function getEmailToken()
    {
        return md5($this->id . '3vbtQXcDQeMJAVhXypk5q9AV9EsN' . $this->email . $this->timeCreated);
    }

    /**
     * Set user's password
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
            $this->addError('password', \yii::t('app', '{attr} length should be less or equal than {val}.', [
                'attr' => $this->getAttributeLabel('password'),
                'val'  => $maxLength,
            ]));
        }

        // Check passwords to be equal
        if ($password != $passwordRepeat) {
            $this->addError('passwordRepeat', \yii::t('app', '{attr} is not confirmed.', [
                'attr' => $this->getAttributeLabel('password'),
            ]));
        }

        // Validate length
        $minLength = 6;
        if (strlen($password) < $minLength) {
            $this->addError('password', \yii::t('app', '{attr} length should be greater or equal than {val}.', [
                'attr' => $this->getAttributeLabel('password'),
                'val'  => $minLength,
            ]));
        }

        // Set password hash if password is valid
        if (!$this->hasErrors('password')) {
            $this->passwordHash = crypt($password, '$6$rounds=5000$jIJM938Jwlfk)394kKkfweofk$');
        }
    }

    /**
     * Check inputed password
     * @param string $password
     * @return bool
     */
    public function checkPassword($password)
    {
        return (crypt($password, $this->passwordHash) === $this->passwordHash);
    }

}
