<?php

namespace common\components;

use \common\models\Geo;
use \common\models\User;

/**
 * Implements checkAccess for $this->user
 *
 * @property User $user
 */
class Rbac extends \CApplicationComponent
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
    const OP_TEAM_DELETE            = 'teamDelete';
    const OP_TEAM_LEAGUE_UPDATE     = 'teamLeagueUpdate';
    const OP_TEAM_PHASE_UPDATE      = 'teamPhaseUpdate';
    const OP_TEAM_EXPORT            = 'teamExport';
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
            if (\yii::app()->getComponent('user') !== null) {
                $this->setUser(\yii::app()->user->getInstance());
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
        return \yii::app()->authManager->checkAccess($operation, (string)$this->user->_id, $params);
    }

    /**
     * Biz rule to suspend/activate students
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleStudentSetStatus(array $params)
    {
        return $this->checkAccess(User::ROLE_COORDINATOR_STATE);
    }

    /**
     * Biz rule to view student's full profile
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleStudentViewFull(array $params)
    {
        $user = $params['user'];
        if ($user->type !== User::ROLE_STUDENT) {
            return false;
        } elseif ($this->checkAccess(User::ROLE_COORDINATOR_STATE)) {
            return true;
        } else {
            return ($this->user->schoolId === $user->schoolId);
        }
    }

    /**
     * Biz rule for activating/suspending of coach
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleCoachSetStatus(array $params)
    {
        $user = $params['user'];
        if ($this->checkAccess(User::ROLE_COORDINATOR_UKRAINE)) {
            return true;
        } elseif ($this->checkAccess(User::ROLE_COORDINATOR_REGION)) {
            return $this->_user->school->region === $user->school->region;
        } elseif ($this->checkAccess(User::ROLE_COORDINATOR_STATE)) {
            return $this->_user->school->state === $user->school->state;
        } else {
            return false;
        }
    }

    /**
     * Biz rule for activating/suspending of coordinators
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleCoordinatorSetStatus(array $params)
    {
        $user = $params['user'];
        if ((string)$this->user->_id === (string)$user->_id) {
            return false;
        } elseif ($user->coordinator === User::ROLE_COORDINATOR_UKRAINE) {
            return $this->checkAccess(User::ROLE_COORDINATOR_UKRAINE);
        } elseif ($user->coordinator === User::ROLE_COORDINATOR_REGION) {
            return $this->checkAccess(User::ROLE_COORDINATOR_UKRAINE);
        } elseif ($user->coordinator === User::ROLE_COORDINATOR_STATE) {
            return $this->checkAccess(User::ROLE_COORDINATOR_REGION);
        } else {
            return false;
        }
    }

    /**
     * Biz rule for reading news
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleNewsRead(array $params)
    {
        $news = $params['news'];
        if ($news->isPublished) {
            return true;
        } else {
            return $this->bizRuleNewsUpdate($params);
        }
    }

    /**
     * Biz rule for edit news
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleNewsUpdate(array $params)
    {
        $geo = $params['news']->geo;

        // Any news
        if ($this->checkAccess(User::ROLE_COORDINATOR_UKRAINE)) {
            return true;
        }

        // Region news
        elseif (in_array($geo, Geo\Region::model()->getConstantList('NAME_'))) {
            return (($geo === $this->user->school->region) && ($this->checkAccess(User::ROLE_COORDINATOR_REGION)));
        }

        // State news
        elseif (in_array($geo, Geo\State::model()->getConstantList('NAME_'))) {
            $region = Geo\State::get($geo)->region->name;
            $stateMatch = (($geo === $this->user->school->state) && ($this->checkAccess(User::ROLE_COORDINATOR_STATE)));
            $regionMatch = (($region === $this->user->school->region) && ($this->checkAccess(User::ROLE_COORDINATOR_REGION)));
            return (($stateMatch) || ($regionMatch));
        }

        // Failed
        else {
            return false;
        }
    }

    /**
     * Biz rule for edit team
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleTeamUpdate(array $params)
    {
        return ((string)$this->user->_id === $params['team']->coachId);
    }

    /**
     * Biz rule for deleting team
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleTeamDelete(array $params)
    {
        return ((string)$this->user->_id === $params['team']->coachId);
    }

    /**
     * Biz rule for set team phase
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleTeamUpdatePhase(array $params)
    {
        return $this->checkAccess(User::ROLE_COORDINATOR_STATE);
    }

    /**
     * Export team (csv)
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleTeamExport(array $params)
    {
        return $this->checkAccess(User::ROLE_COORDINATOR_STATE);
    }

    /**
     * Export users (csv)
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleUserExport(array $params)
    {
        return $this->checkAccess(User::ROLE_COORDINATOR_STATE);
    }

    /**
     * Biz rule to update team's league
     *
     * @param array $params
     * @return bool
     */
    public function bizRuleTeamLeagueUpdate(array $params)
    {
        return $this->checkAccess(User::ROLE_COORDINATOR_STATE);
    }

}