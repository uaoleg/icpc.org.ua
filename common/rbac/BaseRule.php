<?php

namespace common\rbac;

abstract class BaseRule extends \yii\rbac\Rule
{

    /**
     * Permission name
     * @var string
     */
    public $permissionName;

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set rule name, e.g. "\common\rbac\SomeCoolRule" => "some.cool"
        $namespaceParts = explode('\\', static::class);
        $this->name = $namespaceParts[count($namespaceParts) - 1]; // Get class name
        $class = str_replace('Rule', '', $this->name); // Remove "Rule" word
        $classParts = preg_split('/(?=[A-Z])/', $class); // Split class name by capital letters
        array_shift($classParts);
        $this->permissionName = mb_strtolower(implode('.', $classParts));
    }

}
