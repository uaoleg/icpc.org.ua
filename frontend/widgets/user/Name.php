<?php

namespace frontend\widgets\user;

use \common\models\User;
use \frontend\widgets\BaseWidget;
use \yii\helpers\Html;

/**
 * Renders user's full name
 */
class Name extends BaseWidget
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
     * Init
     */
    public function init()
    {
        parent::init();

        // Set language
        if ($this->lang) {
            $this->user::$useLanguage = $this->lang;
        }
    }

    /**
     * Run widget
     */
    public function run()
    {
        // Prepare name parts
        $first  = Html::encode($this->user->firstName);
        $middle = Html::encode($this->user->middleName);
        $last   = Html::encode($this->user->lastName);

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

        echo $name;
    }

}