<?php

namespace common\models;

class School extends \common\ext\MongoDb\Document {


    /**
     * Full university name in ukranian
     * @var string
     */
    public $fullNameUa;

    /**
     * Short university name in ukrainian
     * @var string
     */
    public $shortNameUa;

    /**
     * Full university name in english
     * @var string
     */
    public $fullNameEn;

    /**
     * Short university name in english
     * @var string
     */
    public $shortNameEn;

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
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'school';
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
            'fullNameUa' => \yii::t('app', 'Full university name in ukrainian'),
            'shortNameUa' => \yii::t('app', 'Short university name in ukrainian'),
            'fullNameEn' => \yii::t('app', 'Full university name in english'),
            'shortNameEn' => \yii::t('app', 'Short university name in english'),
            'state' => \yii::t('app', 'State'),
            'region' => \yii::t('app', 'Region'),

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
            array('fullNameUa, state, region', 'required'),
            array('fullNameUa', 'unique')
        ));
    }

}