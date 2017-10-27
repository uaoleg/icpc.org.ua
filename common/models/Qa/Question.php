<?php

namespace common\models\Qa;

use \common\models\BaseActiveRecord;
use \common\models\User;
use \yii\helpers\ArrayHelper;

/**
 * Question
 *
 * @property int    $userId
 * @property string $title
 * @property string $content
 * @property int    $timeCreated
 * @property int    $timeUpdated
 *
 * @property-read Answer[]  $answers
 * @property-read int       $answersCount
 * @property-read string[]  $tags
 * @property-read User      $user
 */
class Question extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%qa_question}}';
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
            'title'         => \yii::t('app', 'Title'),
            'content'       => \yii::t('app', 'Content'),
            'answerCount'   => \yii::t('app', 'Answer count'),
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
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['userId', 'title', 'content'], 'required'],
            ['title', 'string', 'max' => 300],
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

            // Send an email notification about new question
            \yii::$app->cli->runCommand('email', 'newQuestionNotify', ['questionId' => $this->id], [], true);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Returns related answers
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::class, ['questionId' => 'id']);
    }

    /**
     * Returns number of related answers
     * @return int
     */
    public function getAnswersCount()
    {
        return (int)$this->getAnswers()->count();
    }

    /**
     * Returns list of related tags
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        $tags = Tag::find()
            ->alias('tag')
            ->select('tag.name')
            ->innerJoin(['rel' => QuestionTagRel::tableName()], 'rel.tagId = tag.id')
            ->andWhere(['rel.questionId' => $this->id])
            ->asArray()
            ->all()
        ;
        return ArrayHelper::getColumn($tags, 'name');
    }

}