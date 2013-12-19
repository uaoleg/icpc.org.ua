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
    const OP_TEAM_CREATE            = 'teamCreate';
    const OP_TEAM_READ              = 'teamRead';
    const OP_TEAM_UPDATE            = 'teamUpdate';
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
        return $this->checkAccess(User::ROLE_COACH);
    }

}