<?php

namespace web\widgets\user;

use \common\models\User;

class Photo extends \web\ext\Widget
{
    /**
     * Photo
     * @var User\Image
     */
    public $photo;

    /**
     * Run widget
     */
    public function run()
    {
        $photoUrl = '';
        if ($this->photo !== null) {
            $photoUrl = $this->createUrl('/user/photo', array('id' => $this->photo->_id)) . '.jpg';
        }

        // Render view
        $this->render('photo', array(
            'photoUrl' => $photoUrl
        ));
    }
}