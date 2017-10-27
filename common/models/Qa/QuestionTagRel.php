<?php

namespace common\models\Qa;

use \common\models\BaseActiveRecord;

/**
 * Relation between question and tags
 *
 * @property int    $questionId
 * @property int    $tagId
 */
class QuestionTagRel extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%qa_question_tag_rel}}';
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['questionId', 'tagId'], 'required'],
            ['questionId', 'unique', 'targetAttribute' => ['questionId', 'tagId']],
        ]);
    }

}
