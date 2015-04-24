<?php

use \common\ext\Mail\MailMessage;
use \common\models\Qa;
use common\models\User;

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
     * Notifies via email approver about new coach
     *
     * @param string $userName
     * @param string $approverEmail
     */
    public function actionNewCoachNotifyApprover($userName, $approverEmail)
    {
        // Send email
        $message = new MailMessage();
        $message
            ->addTo($approverEmail)
            ->setFrom(\yii::app()->params['emails']['noreply']['address'], \yii::app()->params['emails']['noreply']['name'])
            ->setSubject(@\yii::t('app', '[{app}] There is new coach awaiting for your approval!', array('{app}' => \yii::app()->name)))
            ->setView('newCoachCoordinatorWaitsForApproval', array(
                'link' => \yii::app()->createAbsoluteUrl('/staff/coaches'),
                'name' => $userName
            ));

        \yii::app()->mail->send($message);
    }

    /**
     * Notifies via email approver about new coach
     *
     * @param string $userName
     * @param string $approverEmail
     */
    public function actionNewCoordinatorNotifyApprover($userName, $approverEmail)
    {
        // Send email
        $message = new MailMessage();
        $message
            ->addTo($approverEmail)
            ->setFrom(\yii::app()->params['emails']['noreply']['address'], \yii::app()->params['emails']['noreply']['name'])
            ->setSubject(@\yii::t('app', '[{app}] There is new coordinator awaiting for your approval!', array('{app}' => \yii::app()->name)))
            ->setView('newCoachCoordinatorWaitsForApproval', array(
                'link' => \yii::app()->createAbsoluteUrl('/staff/coordinators'),
                'name' => $userName
            ));

        \yii::app()->mail->send($message);
    }

}
