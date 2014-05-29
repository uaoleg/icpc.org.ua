<?php

namespace web\widgets\user;

use \common\models\User;

class Photo extends \web\ext\Widget
{
    /**
     * Photo
     * @var User\Photo
     */
    public $photo;

    /**
     * Run widget
     */
    public function run()
    {
        // Define photo URL
        if ($this->photo !== null) {
            $photoUrl = $this->createUrl('/user/photo', array('id' => $this->photo->_id)) . '.jpg';
        } else {
            $photoUrl = \yii::app()->theme->baseUrl . '/images/user/photo-256.png';
        }

        // Render view
        $this->render('photo', array(
            'photoUrl' => $photoUrl
        ));
    }
}