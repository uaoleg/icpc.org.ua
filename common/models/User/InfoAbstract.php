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
     * Lang of the information (e.g. "en", "uk")
     * @var string
     */
    public $lang;

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
    public $acmNumber;

    /**
     * School name
     * @var string
     */
    public $schoolName;

    /**
     * Short form of the school name
     * @var string
     */
    public $schoolNameShort;

    /**
     * Official post and email addresses
     * @var string
     */
    public $schoolPostEmailAddresses;

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
            'lang'                         => \yii::t('app', 'Language of the information'),
            'phoneHome'                    => \yii::t('app', 'Home phone number'),
            'phoneMobile'                  => \yii::t('app', 'Mobile phone number'),
            'skype'                        => \yii::t('app', 'Skype'),
            'acmNumber'                    => \yii::t('app', 'ACM number if you have'),
            'schoolName'                   => \yii::t('app', 'School name'),
            'schoolNameShort'              => \yii::t('app', 'Short name of the school name'),
            'schoolPostEmailAddresses'     => \yii::t('app', 'Official post and email addresses')
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
            array('lang, userId, schoolName, schoolNameShort, schoolPostEmailAddresses', 'required'),
            array('phone', InfoAbstract\Validator\Phone::className())
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
            'userId_lang' => array(
                'key' => array(
                    'userId'    => \EMongoCriteria::SORT_ASC,
                    'lang'      => \EMongoCriteria::SORT_ASC,
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

        return true;
    }

    /**
     * After save action
     */
    protected function afterSave()
    {
        // Copy new contacts to the other languages
        if ($this->attributeHasChanged('skype') || $this->attributeHasChanged('phoneHome') ||
            $this->attributeHasChanged('phoneMobile') || $this->attributeHasChanged('acmNumber')
        ) {
            $modifier = new \EMongoModifier();
            $modifier
                ->addModifier('skype', 'set', $this->skype)
                ->addModifier('phoneHome', 'set', $this->phoneHome)
                ->addModifier('phoneMobile', 'set', $this->phoneMobile)
                ->addModifier('acmNumber', 'set', $this->acmNumber);
            $criteria = new \EMongoCriteria();
            $criteria
                ->addCond('userId', '==', (string)$this->userId)
                ->addCond('lang', '!=', $this->lang);
            static::model()->updateAll($modifier, $criteria);
        }
    }


}
