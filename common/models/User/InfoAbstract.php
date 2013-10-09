<?php

namespace common\models\User;

abstract class InfoAbstract extends \common\ext\MongoDb\Document
{

    /**
     * ID of the related user
     * @var string
     */
    public $userId;

    /**
     * Name of university
     * @var string
     */
    public $universityName;

    /**
     * Short form of the name of the univesity
     * @var string
     */
    public $universityShortName;

    /**
     * Official post and email addresses of the university
     * @var string
     */
    public $universityPostEmailAddresses;

    /**
     * Name of the team
     * @var string
     */
    public $universityTeamName;

    /**
     * Middle Name
     * @var string
     */
    public $middleName;

    /**
     * Size of a T-shirt
     * @var string
     */
    public $tshirtSize;

    /**
     * Home phone number
     * @var string
     */
    public $phoneHome;

    /**
     * Mobile phone number
     * @var string
     */
    public $phoneMobile;

    /**
     * Skype
     * @var string
     */
    public $skype;

    /**
     * ACM Number
     * @var string
     */
    public $ACMNumber;

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
            'userId'                       => \yii::t('app', 'Related user ID'),
            'universityName'               => \yii::t('app', 'Name of university'),
            'universityShortName'          => \yii::t('app', 'Short name of the university'),
            'universityPostEmailAddresses' => \yii::t('app', 'Official post and email addresses of the university'),
            'universityTeamName'           => \yii::t('app', 'Name of the team'),
            'lastName'                     => \yii::t('app', 'Last name'),
            'firstName'                    => \yii::t('app', 'First name'),
            'middleName'                   => \yii::t('app', 'Middle name'),
            'email'                        => \yii::t('app', 'Email'),
            'tshirtSize'                   => \yii::t('app', 'T-shirt size'),
            'phoneHome'                    => \yii::t('app', 'Home phone number'),
            'phoneMobile'                  => \yii::t('app', 'Mobile phone number'),
            'skype'                        => \yii::t('app', 'Skype'),
            'ACMNumber'                    => \yii::t('app', 'ACM number if you have')
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
            array('userId, universityName, universityShortName, universityPostEmailAddresses, universityTeamName,
                lastName, firstName, middleName, email, tshirtSize, phoneMobile, skype', 'required'),
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'user.info';
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

}
