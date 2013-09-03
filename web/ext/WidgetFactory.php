<?php

namespace web\ext;

class WidgetFactory extends \CWidgetFactory
{

	/**
	 * Returns the skin for the specified widget class and skin name
     *
	 * @param string $className the widget class name
	 * @param string $skinName the widget skin name
	 * @return array the skin (name=>value) for the widget
	 */
	protected function getSkin($className, $skinName)
    {
        // Fix for class name containing namespace
        $className = str_replace('\\', '_', $className);
        if ($className[0] == '_') {
            $className = mb_substr($className, 1);
        }

        return parent::getSkin($className, $skinName);
    }

}