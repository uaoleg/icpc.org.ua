<?php

namespace common\components;

class ArrayHelper extends \CApplicationComponent
{

    /**
     * Replaces some array keys
     *
     * @param array $array Origin array
     * @param array $rules List of keys to replace
     */
    public function replaceKeys(array &$array, array $rules)
    {
        foreach ($rules as $oldKey => $newKey) {
            if (!isset($array[$oldKey])) {
                continue;
            }
            $array[$newKey] = $array[$oldKey];
            unset($array[$oldKey]);
        }
    }

}