<?php

namespace common\models;

/**
 * School (university, academy, institute)
 *
 * @property-read string $country
 * @property-read string $countryLabel
 * @property-read string $regionLabel
 * @property-read string $stateLabel
 * @property-read string $schoolName
 */
class School extends \common\ext\MongoDb\Document
{

    // Scenarios
    const SC_ASSIGN_TO_TEAM = 'assignToTeam';

    // Available types
    const TYPE_HIGH             = 'high';
    const TYPE_HIGH_CLASSIC     = 'high_classic';
    const TYPE_HIGH_TECHNICAL   = 'high_technical';
    const TYPE_HIGH_ECONOMIC    = 'high_economic';
    const TYPE_HIGH_PEDAGOGICAL = 'high_pedagogical';
    const TYPE_HIGH_NATURAL     = 'high_natural';
    const TYPE_HIGH_LEVEL1      = 'high_level1';
    const TYPE_HIGH_LEVEL2      = 'high_level2';
    const TYPE_MIDDLE           = 'middle';
    const TYPE_COMPANY          = 'company';

    /**
     * Full university name in ukranian
     * @var string
     */
    public $fullNameUk;

    /**
     * Full university name in english
     * @var string
     */
    public $fullNameEn;

    /**
     * Short university name in ukrainian
     * @var string
     */
    public $shortNameUk;

    /**
     * Short university name in english
     * @var string
     */
    public $shortNameEn;

    /**
     * Organization type
     * @var string
     */
    public $type;

    /**
     * State
     * @var string
     */
    public $state;

    /**
     * Region
     * @var string
     */
    public $region;

    /**
     * Returns school name in appropriate language
     *
     * @return string
     */
    public function getSchoolName()
    {
        switch ($this->useLanguage) {
            default:
            case 'uk':
                return $this->fullNameUk;
                break;
            case 'en':
                return (!empty($this->fullNameEn)) ? $this->fullNameEn : $this->fullNameUk;
                break;
        }
    }

    /**
     * Returns country
     *
     * @return string
     */
    public function getCountry()
    {
        return 'ukraine';
    }

    /**
     * Returns country label
     *
     * @return string
     */
    public function getCountryLabel()
    {
        return \yii::t('app', 'Ukraine');
    }

    /**
     * Returns region label
     *
     * @return string
     */
    public function getRegionLabel()
    {
        return Geo\Region::model()->getAttributeLabel($this->region, 'name');
    }

    /**
     * Returns state label
     *
     * @return string
     */
    public function getStateLabel()
    {
        return Geo\State::model()->getAttributeLabel($this->state, 'name');
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
            'fullNameUk'    => \yii::t('app', 'Full university name in ukrainian'),
            'fullNameEn'    => \yii::t('app', 'Full university name in english'),
            'shortNameUk'   => \yii::t('app', 'Short university name in ukrainian'),
            'shortNameEn'   => \yii::t('app', 'Short university name in english'),
            'type'          => \yii::t('app', 'Type'),
            'state'         => \yii::t('app', 'State'),
            'region'        => \yii::t('app', 'Region'),
            'const.type' => array(
                static::TYPE_COMPANY            => \yii::t('app', 'Company'),
                static::TYPE_HIGH               => \yii::t('app', 'High'),
                static::TYPE_HIGH_CLASSIC       => \yii::t('app', 'High classic'),
                static::TYPE_HIGH_ECONOMIC      => \yii::t('app', 'High economic'),
                static::TYPE_HIGH_NATURAL       => \yii::t('app', 'High natural'),
                static::TYPE_HIGH_PEDAGOGICAL   => \yii::t('app', 'High pedagogical'),
                static::TYPE_HIGH_TECHNICAL     => \yii::t('app', 'High technical'),
                static::TYPE_HIGH_LEVEL1        => \yii::t('app', 'High level 1 accreditation'),
                static::TYPE_HIGH_LEVEL2        => \yii::t('app', 'High level 2 accreditation'),
                static::TYPE_MIDDLE             => \yii::t('app', 'Middle school'),
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
            array('fullNameUk, state, region', 'required'),
            array('fullNameUk, fullNameEn, shortNameUk, shortNameEn', 'unique'),
            array('shortNameUk, fullNameEn, shortNameEn', 'required', 'on' => static::SC_ASSIGN_TO_TEAM),
            array('type', School\Validator\Type::className()),
            array('state', School\Validator\State::className()),
            array('region', School\Validator\Region::className()),
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'school';
    }

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'fullNameUk' => array(
                'key' => array(
                    'fullNameUk' => \EMongoCriteria::SORT_ASC,
                ),
                'unique' => true,
            ),
            'fullNameEn' => array(
                'key' => array(
                    'fullNameEn' => \EMongoCriteria::SORT_ASC,
                ),
            ),
            'shortNameUk' => array(
                'key' => array(
                    'shortNameUk' => \EMongoCriteria::SORT_ASC,
                ),
            ),
            'shortNameEn' => array(
                'key' => array(
                    'shortNameEn' => \EMongoCriteria::SORT_ASC,
                ),
            ),
        ));
    }

    /**
     * After save action
     */
    protected function afterSave()
    {
        // If any name is changed than update Result and Team
        foreach (array('fullNameUk', 'fullNameEn') as $attr) {
            if ($this->attributeHasChanged($attr)) {
                $lang = substr($attr, -2);
                $modifier = new \EMongoModifier();
                $modifier->addModifier("schoolName{$lang}", 'set', $this->$attr);
                $criteria = new \EMongoCriteria();
                $criteria->addCond('schoolId', '==', (string)$this->_id);
                Result::model()->updateAll($modifier, $criteria);
                Team::model()->updateAll($modifier, $criteria);
            }
        }

        // If type changed
        if ($this->attributeHasChanged('type')) {
            $modifier = new \EMongoModifier();
            $modifier->addModifier('schoolType', 'set', $this->type);
            $criteria = new \EMongoCriteria();
            $criteria->addCond('schoolId', '==', (string)$this->_id);
            Result::model()->updateAll($modifier, $criteria);
            Team::model()->updateAll($modifier, $criteria);
        }

        parent::afterSave();
    }


}