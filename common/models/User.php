<?php

namespace common\models;

/**
 * User
 *
 * @property-read bool $isApprovedCoordinator
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
    const ROLE_COORDINATOR          = 'coordinator';
    const ROLE_COORDINATOR_UKRAINE  = 'coordinator_ukraine';
    const ROLE_ADMIN                = 'admin';

    /**
     * List of coordinator levels
     */
    const COORD_UKRAINE                 = 'ukraine';
    const COORD_REGION_CENTER           = 'center';
    const COORD_REGION_EAST             = 'east';
    const COORD_REGION_NORTH            = 'north';
    const COORD_REGION_SOUTH            = 'south';
    const COORD_REGION_WEST             = 'west';
    const COORD_STATE_ARC               = 'arc';
    const COORD_STATE_CHERKASY          = 'cherkasy';
    const COORD_STATE_CHERNIHIV         = 'chernihiv';
    const COORD_STATE_CHERNIVTSI        = 'chernivtsi';
    const COORD_STATE_DNIPROPETROVSK    = 'dnipropetrovsk';
    const COORD_STATE_DONETSK           = 'donetsk';
    const COORD_STATE_IVANO_FRANKIVSK   = 'ivano-Frankivsk';
    const COORD_STATE_KHARKIV           = 'kharkiv';
    const COORD_STATE_KHERSON           = 'kherson';
    const COORD_STATE_KHMELNYTSKYI      = 'khmelnytskyi';
    const COORD_STATE_KIEV              = 'kiev';
    const COORD_STATE_KIROVOHRAD        = 'kirovohrad';
    const COORD_STATE_LUHANSK           = 'luhansk';
    const COORD_STATE_LVIV              = 'lviv';
    const COORD_STATE_MYKOLAIV          = 'mykolaiv';
    const COORD_STATE_ODESSA            = 'odessa';
    const COORD_STATE_POLTAVA           = 'poltava';
    const COORD_STATE_RIVNE             = 'rivne';
    const COORD_STATE_SUMY              = 'sumy';
    const COORD_STATE_TERNOPIL          = 'ternopil';
    const COORD_STATE_VINNYTSIA         = 'vinnytsia';
    const COORD_STATE_VOLYN             = 'volyn';
    const COORD_STATE_ZAKARPATTIA       = 'zakarpattia';
    const COORD_STATE_ZAPORIZHIA        = 'zaporizhia';
    const COORD_STATE_ZHYTOMYR          = 'zhytomyr';

    /**
     * First name
     * @var string
     */
    public $firstName;

    /**
     * Last name
     * @var string
     */
    public $lastName;

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
     * Coordination type (static::COORD_)
     * @var string
     */
    public $coordinator;

    /**
     * Date created
     * @var int
     */
    public $dateCreated;

    /**
     * Returns whether coordinator role is approved
     *
     * @return bool
     */
    public function getIsApprovedCoordinator()
    {
        return \yii::app()->authManager->checkAccess(static::ROLE_COORDINATOR, $this->_id);
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
            'firstName'     => \yii::t('app', 'First name'),
            'lastName'      => \yii::t('app', 'Last name'),
            'email'         => \yii::t('app', 'Email'),
            'hash'          => \yii::t('app', 'Password hash'),
            'type'          => \yii::t('app', 'Type'),
            'coordinator'   => \yii::t('app', 'Coordination type'),
            'dateCreated'   => \yii::t('app', 'Registration date'),
            'const.coord'   => array(
                static::COORD_UKRAINE               => \yii::t('app', 'Ukraine'),
                static::COORD_REGION_CENTER         => \yii::t('app', 'Center'),
                static::COORD_REGION_EAST           => \yii::t('app', 'East'),
                static::COORD_REGION_NORTH          => \yii::t('app', 'North'),
                static::COORD_REGION_SOUTH          => \yii::t('app', 'South'),
                static::COORD_REGION_WEST           => \yii::t('app', 'West'),
                static::COORD_STATE_ARC             => \yii::t('app', 'ARC'),
                static::COORD_STATE_CHERKASY        => \yii::t('app', 'Cherkasy'),
                static::COORD_STATE_CHERNIHIV       => \yii::t('app', 'Chernihiv'),
                static::COORD_STATE_CHERNIVTSI      => \yii::t('app', 'Chernivtsi'),
                static::COORD_STATE_DNIPROPETROVSK  => \yii::t('app', 'Dnipropetrovsk'),
                static::COORD_STATE_DONETSK         => \yii::t('app', 'Donetsk'),
                static::COORD_STATE_IVANO_FRANKIVSK => \yii::t('app', 'Ivano-Frankivsk'),
                static::COORD_STATE_KHARKIV         => \yii::t('app', 'Kharkiv'),
                static::COORD_STATE_KHERSON         => \yii::t('app', 'Kherson'),
                static::COORD_STATE_KHMELNYTSKYI    => \yii::t('app', 'Khmelnytskyi'),
                static::COORD_STATE_KIEV            => \yii::t('app', 'Kiev'),
                static::COORD_STATE_KIROVOHRAD      => \yii::t('app', 'Kirovohrad'),
                static::COORD_STATE_LUHANSK         => \yii::t('app', 'Luhansk'),
                static::COORD_STATE_LVIV            => \yii::t('app', 'Lviv'),
                static::COORD_STATE_MYKOLAIV        => \yii::t('app', 'Mykolaiv'),
                static::COORD_STATE_ODESSA          => \yii::t('app', 'Odessa'),
                static::COORD_STATE_POLTAVA         => \yii::t('app', 'Poltava'),
                static::COORD_STATE_RIVNE           => \yii::t('app', 'Rivne'),
                static::COORD_STATE_SUMY            => \yii::t('app', 'Sumy'),
                static::COORD_STATE_TERNOPIL        => \yii::t('app', 'Ternopil'),
                static::COORD_STATE_VINNYTSIA       => \yii::t('app', 'Vinnytsia'),
                static::COORD_STATE_VOLYN           => \yii::t('app', 'Volyn'),
                static::COORD_STATE_ZAKARPATTIA     => \yii::t('app', 'Zakarpattia'),
                static::COORD_STATE_ZAPORIZHIA      => \yii::t('app', 'Zaporizhia'),
                static::COORD_STATE_ZHYTOMYR        => \yii::t('app', 'Zhytomyr'),
            ),
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
            array('firstName, lastName, email, dateCreated', 'required'),
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
        if ((empty($this->coordinator)) || ($this->type === static::ROLE_STUDENT)) {
            $this->coordinator = null;
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
        if ((!$this->_isFirstTimeSaved) && ($this->attributeHasChanged('coordinator'))) {
            \yii::app()->authManager->revoke(static::ROLE_COORDINATOR, $this->_id);
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
        $isValid = (crypt($password, $this->hash) == $this->hash);
        return $isValid;
    }

}