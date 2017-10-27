<?php

namespace common\models;

/**
 * School (university, academy, institute)
 *
 * @property string $fullNameUk
 * @property string $fullNameEn
 * @property string $shortNameUk
 * @property string $shortNameEn
 * @property string $region
 * @property string $state
 * @property string $type
 * @property int    $timeCreated
 * @property int    $timeUpdated
 *
 * @property-read string $country
 * @property-read string $countryLabel
 * @property-read string $regionLabel
 * @property-read string $stateLabel
 * @property-read string $fullName
 */
class School extends BaseActiveRecord
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
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%school}}';
    }

    /**
     * Returns a list of behaviors that this component should behave as
     * @return array
     */
    public function behaviors()
    {
        return [
            $this->behaviorTimestamp(),
        ];
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'fullNameUk'    => \yii::t('app', 'Full university name in ukrainian'),
            'fullNameEn'    => \yii::t('app', 'Full university name in english'),
            'shortNameUk'   => \yii::t('app', 'Short university name in ukrainian'),
            'shortNameEn'   => \yii::t('app', 'Short university name in english'),
            'region'        => \yii::t('app', 'Region'),
            'state'         => \yii::t('app', 'State'),
            'type'          => \yii::t('app', 'Type'),
        ));
    }

    /**
     * Returns the constant labels
     * @return string[]
     */
    public static function constantLabels()
    {
        return [
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
        ];
    }

    /**
     * Define attribute rules
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [

            [['fullNameUk', 'state', 'region'], 'required'],
            [['fullNameUk', 'fullNameEn', 'shortNameUk', 'shortNameEn'], 'unique'],
            [['shortNameUk', 'fullNameEn', 'shortNameEn'], 'required', 'on' => static::SC_ASSIGN_TO_TEAM],

            ['type', 'in', 'range' => $this->getConstants('TYPE_')],

            ['region', 'in', 'range' => Geo\Region::getConstants('NAME_')],

            ['state', 'in', 'range' => Geo\State::getConstants('NAME_')],

        ]);
    }

    /**
     * Returns school name in appropriate language
     *
     * @return string
     */
    public function getFullName()
    {
        switch (static::$useLanguage) {
            default:
            case 'uk':
                return $this->fullNameUk;
            case 'en':
                return (!empty($this->fullNameEn)) ? $this->fullNameEn : $this->fullNameUk;
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
        return Geo\Region::getConstantLabel($this->region);
    }

    /**
     * Returns state label
     *
     * @return string
     */
    public function getStateLabel()
    {
        return Geo\State::getConstantLabel($this->state);
    }

}
