<?php

namespace web\helpers;

class Mail
{
    public function sendMail(array $params)
    {
        $address = isset($params['address']) ? 
            $params['address'] : 
            \yii::app()->params['emails']['noreply']['address'];
        $name = isset($params['name']) ?
            $params['name'] : 
            \yii::app()->params['emails']['noreply']['name'];
        $message = new \common\ext\Mail\MailMessage();
        $message
            ->addTo($params['email'])
            ->setFrom($address, $name)
            ->setSubject($params['subject'])
            ->setView($params['view'], $params['params']);
        \yii::app()->mail->send($message);        
    }
}