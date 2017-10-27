<?php

namespace common\models\Qa;

use \common\models\BaseActiveRecord;

/**
 * Question tag
 *
 * @property string $name
 * @property string $desc
 * @property int    $timeCreated
 * @property int    $timeUpdated
 *
 * @property-read int $questionCount
 */
class Tag extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%qa_tag}}';
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
            'name'          => \yii::t('app', 'Name'),
            'desc'          => \yii::t('app', 'Desc'),
            'timeCreated'   => \yii::t('app', 'Registration date'),
        ));
    }

    /**
     * Returns the number of questions with this tag
     * @return int
     */
    public function getQuestionCount()
    {
        return (int)Question::find()
            ->andWhere(['tagList' => $this->name])
            ->count()
        ;
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['name', 'required'],
            ['name', 'unique'],
            ['name', 'string', 'max' => 100],

            ['desc', 'string', 'max' => 5000],
        ]);
    }

    /**
     * Before save action
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Tag name to lower case
        $this->name = mb_strtolower($this->name);

        return true;
    }

}
