<?php

namespace common\models\User;

class InfoCoach extends Info
{

    /**
     * Position
     * @var string
     */
    public $position;

    /**
     * Office address
     * @var string
     */
    public $officeAddress;

    /**
     * Work phone number
     * @var string
     */
    public $phoneWork;

    /**
     * Fax number
     * @var string
     */
    public $fax;

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
            'position'      => \yii::t('app', 'Position'),
            'officeAddress' => \yii::t('app', 'Office address'),
            'phoneWork'     => \yii::t('app', 'Work phone number'),
            'fax'           => \yii::t('app', 'Fax number')
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
            array('position, officeAddress, phoneWork', 'required', 'except' => static::SC_ALLOW_EMPTY),
        ));
    }

}