<?php

namespace common\models;

/**
 * Base log
 *
 * @property int $time
 */
abstract class BaseLog extends BaseActiveRecord
{

    /**
     * Returns the database connection used by this AR class.
     * By default, the "db" application component is used as the database connection.
     * You may override this method if you want to use a different database connection.
     * @return Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return \yii::$app->dblog;
    }

    /**
     * Before save action
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        // Set current time
        if (!$this->time) {
            $this->time = time();
        }

        return parent::beforeSave($insert);
    }

}

