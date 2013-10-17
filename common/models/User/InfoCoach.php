<?php

namespace common\models\User;

class InfoCoach extends InfoAbstract
{

    /**
     * Coach's position
     * @var string
     */
    public $coachPosition;

    /**
     * Coach's working address
     * @var string
     */
    public $coachWorkindAddress;

    /**
     * Coach's working phone
     * @var string
     */
    public $coachPhoneWork;

    /**
     * Coach's fax number
     * @var string
     */
    public $coachFax;

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
            'coachPosition'       => \yii::t('app', 'Coach\'s position'),
            'coachWorkingAddress' => \yii::t('app', 'Coach\'s working address'),
            'coachPhoneWork'      => \yii::t('app', 'Coach\'s work phone number'),
            'coachFax'            => \yii::t('app', 'Coach\'s fax number')
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
            array('coachPosition, coachWorkingAddress, coachPhoneWork', 'required'),
        ));
    }

}