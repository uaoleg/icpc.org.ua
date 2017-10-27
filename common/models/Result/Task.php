<?php

namespace common\models\Result;

use \common\models\BaseActiveRecord;

/**
 * Result task
 *
 * @property int    $resultId
 * @property string $letter
 * @property itn    $triesCount
 * @property itn    $secondsSpent
 */
class Task extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%result_task}}';
    }

    /**
     * Returns the validation rules for attributes
     * @return array
     */
    public function rules()
    {
        return [
            ['resultId', 'required'],
            ['letter', 'required'],
            ['triesCount', 'number'],
            ['secondsSpent', 'number'],
        ];
    }

}
