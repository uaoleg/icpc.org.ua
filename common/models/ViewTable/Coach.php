<?php
namespace common\models\ViewTable;


class Coach extends \common\models\Person {

    /**
     * Is approved coach
     * @var boolean
     */
    public $isApprovedCoach;

    /**
     * State of his school
     * @var string
     */
    public $state;

    /**
     * State name of his school
     * @var string
     */
    public $stateName;

    /**
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'viewtable.coach';
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
            'state'           => \yii::t('app', 'Code of state'),
            'stateName'       => \yii::t('app', 'Name of state'),
            'isApprovedCoach' => \yii::t('app', 'Is approved coach'),
        ));
    }

}