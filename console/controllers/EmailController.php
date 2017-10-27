<?php

namespace console\controllers;

use \common\ext\Mail\MailMessage;
use \common\models\Qa;
use \common\models\User;
use \yii\helpers\Url;

class EmailController extends BaseController
{

    public function beforeAction($action)
    {
        return false;
    }

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
            ->addTo(\yii::$app->params['emails']['info']['address'])
            ->setFrom(\yii::$app->params['emails']['noreply']['address'], \yyii::$app>params['emails']['noreply']['name'])
            ->setSubject(\yii::t('app', 'A new question was created!'))
            ->setView('new-question-created', array(
                'link' =>Url::toRoute(['/qa/view', 'id' => $questionId], true),
            ));
        \yii::$app->mail->send($message);
    }

    /**
     * Notify about a new answer
     *
     * @param string $answerId
     */
    public function actionNewAnswerNotify($answerId)
    {
        // Get objects
        $answer = Qa\Answer::findOne($answerId);
        $question = $answer->question;
        $user = $question->user;

        // Send email
        $message = new MailMessage();
        $message
            ->addTo($user->email)
            ->setFrom(\yii::$app->params['emails']['noreply']['address'], \yii::$app->params['emails']['noreply']['name'])
            ->setSubject(\yii::t('app', 'A new answer to your question was posted!'))
            ->setView('new-answer-posted', array(
                'link' => Url::toRoute(['/qa/view', 'id' => $question->id], true),
            ));
        \yii::$app->mail->send($message);

    }

    /**
     * Notify about a new Coach or Coordinator
     *
     * @param string $emailTo   Email of parent user
     * @param string $userId    ID of registered user
     */

    public function actionCoachOrCoordinatorNotify($emailTo, $userId)
    {
        // Get user
        $user = User::findOne($userId);
        if (!$user) {
            echo \yii::t('app', 'User not found.');
            exit;
        }

        // Define subject
        if ($user->type === User::ROLE_COACH) {
            $subject = \yii::t('app', 'A new coach is registered and needs your approval!');
        } else {
            $subject = \yii::t('app', 'A new coordinator is registered and needs your approval!');
        }

        // Send email
        $message = new MailMessage();
        $message
            ->addTo($emailTo)
            ->setFrom(\yii::$app->params['emails']['noreply']['address'], \yii::$app->params['emails']['noreply']['name'])
            ->setSubject($subject)
            ->setView('new-coach-or-coordinator-registered', array(
                'user' => $user,
            ));
        \yii::$app->mail->send($message);
    }

}
