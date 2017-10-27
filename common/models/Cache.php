<?php

namespace common\models;

/**
 * Wrapper for \yii::$app->cache
 */
class Cache
{

    /**
     * Cache owner
     * @var object
     */
    protected $owner;

    /**
     * Constructor
     *
     * @param object $owner
     */
    public function __construct($owner)
    {
        if (!is_object($owner)) {
            throw new \yii\base\Exception(\yii::t('app', 'Given cache owner is not an object.'));
        }
        $this->owner = $owner;
    }

    /**
     * Append owner cache key prefix
     *
     * @param string $key
     * @return string
     */
    public function generateUniqueKey($key)
    {
        $uniqueKey = \yii::$app->id . get_class($this->owner);
        if (property_exists($this->owner, 'id')) {
            $uniqueKey .= $this->owner->id;
        }
        $uniqueKey .= $key;
        return $uniqueKey;
    }

    /**
     * Set cache value
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $expire The number of seconds in which the cached value will expire
     * @param \ICacheDependency $dependency
     */
    public function set($key, $value, $expire = 0, \ICacheDependency $dependency = null)
    {
        \yii::$app->cache->set($this->generateUniqueKey($key), $value, $expire, $dependency);
    }

    /**
     * Get cache value
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return \yii::$app->cache->get($this->generateUniqueKey($key));
    }

    /**
     * Delete cache value
     *
     * @param string $key
     */
    public function delete($key)
    {
        \yii::$app->cache->delete($this->generateUniqueKey($key));
    }

}
