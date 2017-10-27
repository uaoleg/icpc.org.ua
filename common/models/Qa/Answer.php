<?php

namespace common\models\Qa;

use \common\models\BaseActiveRecord;
use \common\models\User;

/**
 * Answer
 *
 * @property int    $userId
 * @property int    $questionId
 * @property string $content
 * @property int    $timeCreated
 * @property int    $timeUpdated
 *
 * @property-read User      $user
 * @property-read Question  $question
 */
class Answer extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%qa_answer}}';
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
            'userId'        => \yii::t('app', 'User ID'),
            'questionId'    => \yii::t('app', 'Question ID'),
            'content'       => \yii::t('app', 'Content'),
            'timeCreated'   => \yii::t('app', 'Registration date'),
        ));
    }

    /**
     * Returns answer author
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }

    /**
     * Returns related question
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::class, ['id' => 'questionId']);
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['userId', 'questionId', 'content'], 'required'],
            ['content', 'string', 'max' => 5000],
        ]);
    }

    /**
     * After save action
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {

            // Send an email notification about new answer
            \yii::$app->cli->runCommand('email', 'newAnswerNotify', ['answerId' => $this->id], [], true);
        }

        parent::afterSave($insert, $changedAttributes);
    }

}