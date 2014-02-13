<?php

namespace common\ext\MongoDb;

\CValidator::$builtInValidators = array_merge(\CValidator::$builtInValidators, array(
    'readonly'  => '\common\ext\MongoDb\Validator\Readonly',
    'unique'    => '\common\ext\MongoDb\Validator\Unique',
));

/**
 * Abstract document
 *
 * @property boolean $isNewRecord
 * @property string  $useLanguage
 */
abstract class Document extends \EMongoDocument
{

    /**
     * Object is new or saved just once
     * @var bool
     * @see beforeSave()
     * @see afterSave()
     */
    protected $_isFirstTimeSaved = true;

    /**
     * Attributes as they are in DB (not changed)
     * @var array
     * @see afterSave()
     * @see afterFind()
     */
    protected $_initialAttributes = array();

    /**
     * Language to use for multilang properties
     * @var string
     */
    protected $_useLanguage;


    /**
     * Sets language to use for multilang properties
     *
     * @param string $lang
     * @return \common\ext\MongoDb\Document
     */
    public function setUseLanguage($lang)
    {
        $this->_useLanguage = $lang;
        return $this;
    }

    /**
     * Returns language to use for multilang properties
     *
     * @return string
     */
    public function getUseLanguage()
    {
        if ($this->_useLanguage === null) {
            $this->_useLanguage = \yii::app()->language;
        }
        return $this->_useLanguage;
    }

    /**
     * Returns class name
     *
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Store initial attributes
        $this->_initialAttributes = $this->toArrayUnwindEmbedded();
    }

    /**
     * Get object unique ID
     *
     * @return string
     */
    public function getUniqueId()
    {
        return get_class($this) . '\\' . $this->_id;
    }

    /**
     * Returns MongoId extracted from UniqueId
     *
     * @param string $uniqueId
     * @return string
     */
    public function extractId($uniqueId)
    {
        return substr($uniqueId, -24);
    }

    /**
     * Find document by unique ID
     *
     * @param string $uniqueId
     * @return Document
     */
    public static function findByUniqueId($uniqueId)
    {
        $class = substr($uniqueId, 0, strrpos($uniqueId, '\\'));
        $id    = substr($uniqueId, strrpos($uniqueId, '\\') + 1);
        if (class_exists($class)) {
            return $class::model()->findByPk(new \MongoId($id));
        } else {
            return null;
        }
    }

    /**
     * Returns the model of called class
     *
     * @param string $className EMongoDocument class name
     * @return EMongoDocument model instance
     */
    public static function model($className = null)
    {
        if ($className === null) {
            $className = get_called_class();
        }
        return parent::model($className);
    }

    /**
     * Returns the given object as an associative array
     *
     * @return array
     */
    public function toArrayUnwindEmbedded()
    {
        $attrs = $this->toArray();
        foreach ($this->embeddedDocuments() as $embeddedField => $embeddedClass) {
            unset($attrs[$embeddedField]);
            foreach ($this->$embeddedField->toArray() as $key => $value) {
                $attrs[$embeddedField . ucfirst($key)] = $value;
            }
        }
        return $attrs;
    }

	/**
	 * Finds all documents satisfying the specified condition and returns the first one.
     * Is used one need to find one with the sorting.
     *
	 * @param array|EMongoCriteria $condition query criteria.
	 * @return Document
	 */
	public function findFirst($criteria = null)
    {
        $result = $this->findAll($criteria);
        $result->limit(1);
        $result->next();
        return $result->current();
    }

    /**
     * Before save action
     *
     * @return bool
     */
    protected function beforeSave()
    {
        if (!parent::beforeSave()) return false;

        // Set first time saved equal to is new record
        $this->_isFirstTimeSaved = $this->getIsNewRecord();

        return true;
    }

    /**
     * After save action
     */
    protected function afterSave()
    {
        // Set first time saved to false
        $this->_isFirstTimeSaved = false;

        // Store initial attributes
        $this->_initialAttributes = $this->toArrayUnwindEmbedded();

        parent::afterSave();
    }

    /**
     * After find action
     */
    protected function afterFind()
    {
        // Store initial attributes
        $this->_initialAttributes = $this->toArrayUnwindEmbedded();

        parent::afterFind();
    }

    /**
     * Before delete action
     *
     * @return bool
     */
    protected function beforeDelete()
    {
        if (!parent::beforeDelete()) return false;

        // Check if is new record
        if ($this->getIsNewRecord()) {
            return false;
        }

        return true;
    }

    /**
     * After delete action
     */
    protected function afterDelete()
    {
        parent::afterDelete();
        $this->setIsNewRecord(true);
    }

    /**
     * Deletes the row corresponding to this EMongoDocument.
     *
     * @return bool
     */
    public function delete()
    {
        if (!$this->getIsNewRecord()) {
            $result = $this->deleteByPk($this->getPrimaryKey());
            return ($result !== false);
        } else {
            throw new \CDbException(\yii::t('app', 'The EMongoDocument cannot be deleted because it is new.'));
        }
    }

    /**
     * Perform an aggregation using the aggregation framework
     *
     * @param array $pipeline Array of pipeline operator
     * @param array $options List of additional options:
     *  - populateRecords = true
     *  - saveDocumentFields = true
     * @return array List of matched objects
     */
    public function aggregate(array $pipeline, array $options = array())
    {
        // Set default options
        if (!isset($options['populateRecords'])) {
            $options['populateRecords'] = true;
        }
        if (!isset($options['saveDocumentFields'])) {
            $options['saveDocumentFields'] = true;
        }

        // Is should save document fields
        if ((isset($options['saveDocumentFields'])) && ($options['saveDocumentFields'])) {
            foreach ($pipeline as &$operator) {
                if (isset($operator['$project'])) {
                    $operator['$project'] = array_merge(
                        $operator['$project'],
                        array_fill_keys($this->attributeNames(), 1)
                    );
                }
            }
        }

        // Make aggregation request
        $db = $this->getDb();
        $result = $db->command(array(
            'aggregate' => $this->getCollectionName(),
            'pipeline'  => $pipeline,
        ));

        // If some error occured
        if ((!$result['ok']) && (isset($result['errmsg']))) {
            throw new \Exception($result['errmsg']);
        }

        // Populate records
        if ((isset($options['populateRecords'])) && ($options['populateRecords'])) {
            $objectList = array();
            foreach ($result['result'] as $doc) {
                $objectList[] = static::model()->populateRecord($doc);
            }
            return $objectList;
        }
        // Return array
        else {
            return $result['result'];
        }
    }

    /**
     * Get list of constants
     *
     * @param string $namespace Constants prefix
     * @return array
     */
    public function getConstantList($namespace = '')
    {
        $constantList = array();
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getConstants() as $key => $value) {
            if ($namespace !== '')
                if (strpos($key, $namespace) !== 0) continue;
            $constantList[$key] = $value;
        }
        return $constantList;
    }

	/**
	 * Returns the text label for the specified attribute
     *
	 * @param string $attribute
     * @param string $const
	 * @return string
	 */
	public function getAttributeLabel($attribute, $const = '')
	{
		$labels = $this->attributeLabels();
        if ((!empty($const)) && (isset($labels['const.' . $const][$attribute]))) {
            return $labels['const.' . $const][$attribute];
        } elseif (isset($labels[$attribute])) {
			return $labels[$attribute];
        } else {
			return $this->generateAttributeLabel($attribute);
        }
	}

    /**
     * Check if attribute has been changed after last find or save
     *
     * @param string $attrName
     * @return bool
     */
    public function attributeHasChanged($attrName)
    {
        if (array_key_exists($attrName, $this->_initialAttributes)) {
            return !($this->_initialAttributes[$attrName] === $this->$attrName);
        } else {
            return true;
        }
    }

    /**
     * Returns init attribute value
     *
     * @param string $attrName
     * @param mixed  $defaultValue
     * @return mixed
     */
    public function attributeInitValue($attrName, $defaultValue = null)
    {
        if (isset($this->_initialAttributes[$attrName])) {
            return $this->_initialAttributes[$attrName];
        } else {
            return $defaultValue;
        }
    }

    /**
     * Returns difference between initial and current attribute values
     *
     * @return array
     */
    public function attributesChanges()
    {
        // Log profile change
        $initialAttrs = $this->_initialAttributes;
        $finalAttrs = $this->toArrayUnwindEmbedded();

        // Show only final values if section is just created
        $initialValues = $finalValues = array();
        $changed = true;
        if (count($initialAttrs) > 0) {

            // If both arrays coinside don't write log
            if ($initialAttrs !== $finalAttrs) {
                foreach ($initialAttrs as $key => $initialValue) {
                    // Log fields which where changed
                    if ($initialValue !== $finalAttrs[$key] ) {
                        $initialValues[$key] = $initialValue;
                        $finalValues[$key]   = $finalAttrs[$key];
                    }
                }
            } else {
                $changed = false;
            }
        } else {
            // Show only final values if section is just created
            $finalValues = $finalAttrs;
        }

        return array(
            'changed'   => $changed,
            'initial'   => $initialValues,
            'final'     => $finalValues,
        );
    }

    /**
     * Log attributes changes
     */
    public function attributesChangesLog()
    {
        // Get changes
        $changes = $this->attributesChanges();
        if (!$changes['changed']) {
            return;
        }

        // Define category
        $category = 'staff.logchange.' . get_class($this) . '.';

        // Log each change
        foreach ($changes['initial'] as $key => $value) {
            \yii::log(array(
                'init'  => $value,
                'final' => $changes['final'][$key],
            ), \CLogger::LEVEL_INFO, $category . $key . '.' . $this->_id);
        }
    }

    /**
     * Returns max length of the string attribute
     *
     * @param string $attribute
     * @return int
     */
    public function getAttributeMaxLength($attribute)
    {
        $validators = $this->getValidators($attribute);
        foreach ($validators as $validator) {
            if ($validator instanceof \CStringValidator) {
                return $validator->max;
            }
        }
        return 0;
    }

    /**
     * Get errors.
     * All embedded errors are prefixed with embedded field name.
     *
     * @return array
     */
    public function getErrorsUnwindEmbedded()
    {
        $errors = $this->getErrors();

        foreach ($this->embeddedDocuments() as $field => $class) {
            foreach ($this->$field->getErrors() as $embeddedField => $embeddedErrors) {
                $errors[$field . ucfirst($embeddedField)] = $embeddedErrors;
                unset($errors[$embeddedField]);
            }
        }

        return $errors;
    }

    /**
     * Converts date to timestamp
     *
     * @param int|string $date
     * @return int
     */
    protected function _getSafeDate($date)
    {
        // If date is empty, then return null
        if (empty($date)) {
            return null;
        }

        // If already is a timestamp
        if (is_int($date)) {
            return $date;
        }

        // Is string
        elseif (is_string($date)) {

            // If already timestamp by as a string
            if (($date == (int)$date) && (strlen($date) == strlen('1354039920'))) {
                $date = (int)$date;
            }

            // Convert string to time
            else {
                $date = strtotime($date . ' UTC');
                if ($date === false) {
                    $date = null;
                }
            }

            return $date;
        }

        // Otherway
        else {
            return null;
        }
    }

}