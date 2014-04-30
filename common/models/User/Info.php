<?php

namespace common\models\User;

class Info extends \common\ext\MongoDb\Document
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
     * Date of birth
     * @var string
     */
    public $dateOfBirth;

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
     * T-shirt size
     * @var string
     */
    public $tShirtSize;

    /**
     * ACM Number
     * @var string
     */
    public $acmNumber;

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
            'dateOfBirth'                  => \yii::t('app', 'Date of birth'),
            'phoneHome'                    => \yii::t('app', 'Home phone number'),
            'phoneMobile'                  => \yii::t('app', 'Mobile phone number'),
            'skype'                        => \yii::t('app', 'Skype'),
            'tShirtSize'                   => \yii::t('app', 'T-shirt size'),
            'acmNumber'                    => \yii::t('app', 'ACM number if you have'),
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
            array('lang, userId, dateOfBirth, tShirtSize', 'required'),
            array('dateOfBirth', 'date', 'format' => 'dd/mm/yyyy'),
            array('tShirtSize', 'in', 'range' => array('XS', 'S', 'M', 'L', 'XL', 'XXL')),
            array('phone', Info\Validator\Phone::className())
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
            $this->attributeHasChanged('phoneMobile') || $this->attributeHasChanged('acmNumber') ||
            $this->attributeHasChanged('tShirtSize')
        ) {
            $modifier = new \EMongoModifier();
            $modifier
                ->addModifier('skype', 'set', $this->skype)
                ->addModifier('phoneHome', 'set', $this->phoneHome)
                ->addModifier('phoneMobile', 'set', $this->phoneMobile)
                ->addModifier('tShirtSize', 'set', $this->tShirtSize)
                ->addModifier('acmNumber', 'set', $this->acmNumber);
            $criteria = new \EMongoCriteria();
            $criteria
                ->addCond('userId', '==', (string)$this->userId)
                ->addCond('lang', '!=', $this->lang);
            static::model()->updateAll($modifier, $criteria);
        }
    }


}
