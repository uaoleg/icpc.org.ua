<?php

namespace common\models;

/**
 * @property int $id
 *
 * @property-read Cache $cache
 */
class BaseActiveRecord extends \yii\db\ActiveRecord
{

    use \common\traits\ModelFormIdTrait;

    /**
     * @var string
     */
    public static $useLanguage = 'uk';

    /**
     * List of cached values
     * @var array
     */
    protected $cachedAttributes = [];

    /**
     * Returns object ID
     * @param BaseActiveRecord $object
     * @return string
     */
    public static function getObjectId(BaseActiveRecord $object)
    {
        return get_class($object) . '\\' . $object->id;
    }

    /**
     * Returns object by it's ID
     * @param string $objectId
     * @return BaseActiveRecord
     */
    public static function findObject($objectId)
    {
        $lastSlashPos = strrpos($objectId, '\\');
        $class = substr($objectId, 0, $lastSlashPos);
        $id = (int)substr($objectId, $lastSlashPos + 1);
        return $class::findOne($id);
    }

    /**
     * Get list of constants
     * @param string $namespace Constants prefix
     * @return array
     */
    public static function getConstants($namespace = '')
    {
        $constants = [];
        $reflection = new \ReflectionClass(static::class);
        foreach ($reflection->getConstants() as $key => $value) {
            if ($namespace !== '') {
                if (strpos($key, $namespace) !== 0) {
                    continue;
                }
            }
            $constants[$key] = $value;
        }
        return $constants;
    }

    /**
     * Returns the constant labels
     * @return string[]
     */
    public static function constantLabels()
    {
        return [];
    }

    /**
     * Returns the text label for the specified constant
     * @param string $constant
     * @return string
     */
    public static function getConstantLabel($constant)
    {
        $labels = static::constantLabels();
        return $labels[$constant] ?? $constant;
    }

    /**
     * Returns default configuration for AttributeTypecastBehavior
     * @return array
     */
    public function behaviorAttributeTypecast()
    {
        return [
            'class' => \yii\behaviors\AttributeTypecastBehavior::class,
            'owner' => $this,
            'typecastAfterFind' => true,
        ];
    }

    /**
     * Returns default configuration for AesBehavior
     * @param array $attributes
     * @return array
     */
    public function behaviorAttributeProtect(array $attributes)
    {
        return ['attributeProtect' => [
            'class' => \common\behaviors\AesBehavior::class,
            'key' => \yii::$app->params['aes.key'],
            'attributes' => $attributes,
        ]];
    }

    /**
     * Returns default configuration for DateTimeFormatBehavior
     * @param array $attributes
     * @return array
     */
    public function behaviorDateFormat(array $attributes)
    {
        return [
            'class'         => \common\behaviors\DateTimeFormatBehavior::class,
            'attributes'    => $attributes,
            'dbFormat'      => \DATE_FORMAT_DB,
            'viewFormat'    => \yii::$app->formatter->dateFormat,
        ];
    }

    /**
     * Returns default configuration for DateTimeFormatBehavior
     * @param array $attributes
     * @return array
     */
    public function behaviorDateTimeFormat(array $attributes)
    {
        return [
            'class'         => \common\behaviors\DateTimeFormatBehavior::class,
            'attributes'    => $attributes,
            'dbFormat'      => \DATE_TIME_FORMAT_DB,
            'viewFormat'    => \yii::$app->formatter->datetimeFormat,
        ];
    }

    /**
     * Returns default configuration for JsonBehavior
     * @param array $attributes
     * @return array
     */
    public function behaviorJson(array $attributes)
    {
        return [
            'class' => \common\behaviors\JsonBehavior::class,
            'attributes' => $attributes,
        ];
    }

    /**
     * Auto generate hash ID
     * @return array
     */
    public function behaviorHashId()
    {
        return [
            'class' => \common\behaviors\HashIdBehavior::class,
            'attributes' => ['hash'],
        ];
    }

    /**
     * Returns default configuration for TimestampBehavior
     * @return array
     */
    public function behaviorTimestamp()
    {
        return [
            'class' => \yii\behaviors\TimestampBehavior::class,
            'createdAtAttribute' => 'timeCreated',
            'updatedAtAttribute' => 'timeUpdated',
            'attributes' => [
                static::EVENT_BEFORE_INSERT => ['timeCreated'],
                static::EVENT_BEFORE_UPDATE => ['timeUpdated'],
            ],
//            'value' => function() { return date('Y:m:d H:i:s'); },
        ];
    }

    /**
     * Returns form name array by ID
     * @return string
     */
    public function formNameWithId()
    {
        return "{$this->formName()}[{$this->id}]";
    }

    /**
     * Returns a value indicating whether there is any validation error for given child
     * @param BaseActiveRecord $child
     * @return boolean
     */
    public function hasErrorsForChild(BaseActiveRecord $child)
    {
        $formName = $child->formNameWithId();
        foreach ($this->errors as $attr => $errors) {
            if (mb_strpos($attr, $formName) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Saves the current record
     * @param bool $runValidation
     * @param array $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        /**
         * Force update time if attribute wasn't included into attribute names
         * @todo Rewrite TimestampBehavior as a trait and move this logic into it
         */
        if ($this->hasAttribute('timeUpdated') && $attributeNames) {
            $attributeNames[] = 'timeUpdated';
        }

        return parent::save($runValidation, $attributeNames);
    }

    /**
     * Check if attribute changed after save
     * @link https://github.com/yiisoft/yii2/issues/2892 Known Yii2 issue
     * @param string $attributeName
     * @param array $changedAttributes
     * @return bool
     */
    public function isAttributeChangedAfterSave($attributeName, array $changedAttributes)
    {
        return \yii\helpers\ArrayHelper::keyExists($attributeName, $changedAttributes) && ($this->$attributeName != $changedAttributes[$attributeName]);
    }

    /**
     * Returns whether attribute should be validated or not
     * Should be used in validate() method
     * @param string $attributeName
     * @param array|null $attributeNames
     * @return bool
     */
    public function isAttributeNeedsValidation($attributeName, $attributeNames)
    {
        return (!$attributeNames || (is_array($attributeNames) && in_array($attributeName, $attributeNames)));
    }

    /**
     * Repopulates this active record with the latest data
     * @return bool
     */
    public function refresh()
    {
        if (!parent::refresh()) {
            return false;
        }

        $this->flushCachedAttributes();

        return true;
    }

    /**
     * Flush cached attributes
     */
    public function flushCachedAttributes()
    {
        $this->cachedAttributes = [];
    }

    /**
     * Returns cache entity
     * @return Cache
     */
    public function getCache()
    {
        return new Cache($this);
    }


}
