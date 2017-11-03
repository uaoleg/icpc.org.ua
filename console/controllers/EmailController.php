<?php

namespace console\controllers;

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
        \yii::$app->email
            ->compose()
            ->setFrom([\yii::$app->params['emails']['noreply']['address'] => \yii::$app->params['emails']['noreply']['name']])
            ->setTo(\yii::$app->params['emails']['info']['address'])
            ->setSubject(\yii::t('app', 'A new question was created!'))
            ->setViewBody('new-question-created', [
                'link' =>Url::toRoute(['/qa/view', 'id' => $questionId], true),
            ])
            ->send()
        ;
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
        \yii::$app->email
            ->compose()
            ->setFrom([\yii::$app->params['emails']['noreply']['address'] => \yii::$app->params['emails']['noreply']['name']])
            ->setTo($user->email)
            ->setSubject(\yii::t('app', 'A new answer to your question was posted!'))
            ->setViewBody('new-answer-posted', [
                'link' => Url::toRoute(['/qa/view', 'id' => $question->id], true),
            ])
            ->send()
        ;
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
        \yii::$app->email
            ->compose()
            ->setFrom([\yii::$app->params['emails']['noreply']['address'] => \yii::$app->params['emails']['noreply']['name']])
            ->setTo($emailTo)
            ->setSubject($subject)
            ->setViewBody('new-coach-or-coordinator-registered', [
                'user' => $user,
            ])
            ->send()
        ;
    }

}
