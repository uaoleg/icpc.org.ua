<?php

namespace frontend\widgets\user;

use \common\models\User;
use \frontend\widgets\BaseWidget;
use \yii\helpers\Url;

class Photo extends BaseWidget
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
            $photoUrl = Url::toRoute(['/user/photo', 'id' => $this->photo->id]);
        } else {
            $photoUrl = Url::to('@web/images/user/photo-256.png');
        }

        // Render view
        return $this->render('photo', array(
            'photoUrl' => $photoUrl,
        ));
    }
}