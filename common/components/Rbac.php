<?php

namespace common\components;

use \common\models\User;

/**
 * Implements checkAccess for $this->user
 *
 * @property User $user
 */
class Rbac extends \yii\base\Component
{

    /**
     * List of available operations
     */
    const OP_COACH_SET_STATUS       = 'coachSetStatus';
    const OP_COORDINATOR_SET_STATUS = 'coordinatorSetStatus';
    const OP_DOCUMENT_CREATE        = 'documentCreate';
    const OP_DOCUMENT_READ          = 'documentRead';
    const OP_DOCUMENT_UPDATE        = 'documentUpdate';
    const OP_DOCUMENT_DELETE        = 'documentDelete';
    const OP_NEWS_CREATE            = 'newsCreate';
    const OP_NEWS_READ              = 'newsRead';
    const OP_NEWS_UPDATE            = 'newsUpdate';
    const OP_RESULT_CREATE          = 'resultCreate';
    const OP_RESULT_TEAM_DELETE     = 'resultTeamDelete';
    const OP_STUDENT_VIEW_FULL      = 'studentViewFull';
    const OP_STUDENT_SET_STATUS     = 'studentSetStatus';
    const OP_TEAM_CREATE            = 'teamCreate';
    const OP_TEAM_READ              = 'teamRead';
    const OP_TEAM_UPDATE            = 'teamUpdate';
    const OP_TEAM_SYNC              = 'teamSync';
    const OP_TEAM_DELETE            = 'teamDelete';
    const OP_TEAM_LEAGUE_UPDATE     = 'teamLeagueUpdate';
    const OP_TEAM_PHASE_UPDATE      = 'teamPhaseUpdate';
    const OP_TEAM_EXPORT_ALL        = 'teamExportAll';
    const OP_TEAM_EXPORT_ONE        = 'teamExportOne';
    const OP_USER_EXPORT            = 'userExport';
    const OP_QA_ANSWER_CREATE       = 'qaAnswerCreate';
    const OP_QA_ANSWER_READ         = 'qaAnswerRead';
    const OP_QA_ANSWER_UPDATE       = 'qaAnswerUpdate';
    const OP_QA_ANSWER_DELETE       = 'qaAnswerDelete';
    const OP_QA_COMMENT_CREATE      = 'qaCommentCreate';
    const OP_QA_COMMENT_READ        = 'qaCommentRead';
    const OP_QA_COMMENT_UPDATE      = 'qaCommentUpdate';
    const OP_QA_COMMENT_DELETE      = 'qaCommentDelete';
    const OP_QA_QUESTION_CREATE     = 'qaQuestionCreate';
    const OP_QA_QUESTION_READ       = 'qaQuestionRead';
    const OP_QA_QUESTION_UPDATE     = 'qaQuestionUpdate';
    const OP_QA_QUESTION_DELETE     = 'qaQuestionDelete';
    const OP_QA_TAG_CREATE          = 'qaTagCreate';
    const OP_QA_TAG_READ            = 'qaTagRead';
    const OP_QA_TAG_UPDATE          = 'qaTagUpdate';
    const OP_QA_TAG_DELETE          = 'qaTagDelete';
    const OP_USER_READ_EMAIL        = 'userReadEmail';

    /**
     * Current user
     * @var User
     */
    protected $_user;

    /**
     * Set current user
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->_user = $user;
    }

    /**
     * Returns current user
     *
     * @return User
     */
    public function getUser()
    {
        if ($this->_user === null) {
            if (\yii::$app->user && \yii::$app->user->identity) {
                $this->setUser(\yii::$app->user->identity);
            } else {
                $this->setUser(new User());
            }
        }
        return $this->_user;
    }

    /**
     * Check access shortcut
     *
     * @param string $operation
     * @param array $params
     * @return bool
     */
    public function checkAccess($operation, array $params = array())
    {
throw new \Exception;
        return \yii::$app->authManager->checkAccess($this->user->id, $operation, $params);
    }

}
