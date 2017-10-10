<?php

namespace web\widgets\user;

use \common\models\User;

/**
 * Renders user's full name
 */
class Name extends \web\ext\Widget
{

    /**
     * Available views
     */
    const VIEW_FIRST                = 'first';
    const VIEW_FIRST_MIDDLE_LAST    = 'firstMiddleLast';
    const VIEW_LAST_FIRST_MIDDLE    = 'lastFirstMiddle';

    /**
     * User
     * @var User
     */
    public $user;

    /**
     * View type
     * @var string
     */
    public $view;

    /**
     * Language in which name is needed
     * @var string
     */
    public $lang;

    /**
     * Run widget
     */
    public function run()
    {
        // Prepare name parts
        $this->user->useLanguage = $this->lang;
        $first  = \CHtml::encode($this->user->firstName);
        $middle = \CHtml::encode($this->user->middleName);
        $last   = \CHtml::encode($this->user->lastName);

        // Render full name
        switch ($this->view) {
            case static::VIEW_FIRST:
                $name = "{$first}";
                break;
            default:
            case static::VIEW_FIRST_MIDDLE_LAST:
                $name = "{$first} {$middle} {$last}";
                break;
            case static::VIEW_LAST_FIRST_MIDDLE:
                $name = "{$last} {$first} {$middle}";
                break;
        }
        $name = trim($name);

        // Set email in case of empty name
        if (empty($name)) {
            $name = $this->user->email;
        }

        return $name;
    }

}