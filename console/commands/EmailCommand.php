<?php

use \common\ext\Mail\MailMessage;
use \common\models\Qa;

class EmailCommand extends \console\ext\ConsoleCommand
{

    /**
     * Notify about a new question
     *
     * @param string $questionId
     */
    public function actionNewQuestionNotify($questionId)
    {
        // Send email
        $message = new MailMessage();
        $message
            ->addTo(\yii::app()->params['emails']['info']['address'])
            ->setFrom(\yii::app()->params['emails']['noreply']['address'], \yii::app()->params['emails']['noreply']['name'])
            ->setSubject(\yii::t('app', 'A new question was created!'))
            ->setView('newQuestionCreated', array(
                'link' => \yii::app()->createAbsoluteUrl('/qa/view', array('id' => $questionId)),
            ));
        \yii::app()->mail->send($message);
    }

    /**
     * Notify about a new answer
     *
     * @param string $answerId
     */
    public function actionNewAnswerNotify($answerId)
    {
        // Get objects
        $answer = Qa\Answer::model()->findByPk(new MongoId($answerId));
        $question = $answer->question;
        $user = $question->user;

        // Send email
        $message = new MailMessage();
        $message
            ->addTo($user->email)
            ->setFrom(\yii::app()->params['emails']['noreply']['address'], \yii::app()->params['emails']['noreply']['name'])
            ->setSubject(\yii::t('app', 'A new answer to your question was posted!'))
            ->setView('newAnswerPosted', array(
                'link' => \yii::app()->createAbsoluteUrl('/qa/view', array('id' => $question->_id)),
            ));
        \yii::app()->mail->send($message);

    }
    
    /**
     * Notify about a new Coach or Coordinator
     *
     * @param string $emailTo - Email of parrent user
     * @param string $user_email - Email of registered user
     * @param string $role
     */
    
    public function actionCoachOrCoordinatorNotify($emailTo, $user_email, $role)
    {
        // Send email
        $message = new MailMessage();
        $message
            ->addTo($emailTo)
            ->setFrom(\yii::app()->params['emails']['noreply']['address'], \yii::app()->params['emails']['noreply']['name'])
            ->setSubject(\yii::t('app', 'A new Coach or Coordinator registered and need approval!'))
            ->setView('newCoachRegistered', array(
                'role' => $role,
                'email' => $user_email,
            ));
        \yii::app()->mail->send($message);
    }

}
