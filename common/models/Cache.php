<?php

namespace common\models;

/**
 * Wrapper for \yii::app()->cache
 */
class Cache
{

    /**
     * Cache owner
     * @var object
     */
    protected $_owner;

    /**
     * Constructor
     *
     * @param object $owner
     */
    public function __construct($owner)
    {
        if (!is_object($owner)) {
            throw new \CException(\yii::t('app', 'Given cache owner is not an object.'));
        }
        $this->_owner = $owner;
    }

    /**
     * Append owner cache key prefix
     *
     * @param string $key
     * @return string
     */
    public function generateUniqueKey($key)
    {
        $uniqueKey = \yii::app()->getId() . get_class($this->_owner);
        if (property_exists($this->_owner, '_id')) {
            $uniqueKey .= $this->_owner->_id;
        }
        $uniqueKey .= $key;
        return $uniqueKey;
    }

    /**
     * Set cache value
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $expire
     * @param \ICacheDependency $dependency
     */
    public function set($key, $value, $expire = 0, \ICacheDependency $dependency = null)
    {
        \yii::app()->cache->set($this->generateUniqueKey($key), $value, $expire, $dependency);
    }

    /**
     * Get cache value
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return \yii::app()->cache->get($this->generateUniqueKey($key));
    }

    /**
     * Delete cache value
     *
     * @param string $key
     */
    public function delete($key)
    {
        \yii::app()->cache->delete($this->generateUniqueKey($key));
    }

}