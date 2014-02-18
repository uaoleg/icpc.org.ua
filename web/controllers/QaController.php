<?php

namespace web\controllers;

use \common\components\Rbac;
use \common\models\Qa;

class QaController extends \web\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'latest';

        // Set active main menu item
        $this->setNavActiveItem('main', 'qa');
    }

    /**
     * Returns the access rules for this controller
     *
     * @return array
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions'   => array('create'),
                'roles'     => array(Rbac::OP_QA_QUESTION_CREATE),
            ),
            array(
                'deny',
                'actions'   => array('create'),
            ),
            array(
                'allow',
                'actions'   => array('update'),
                'roles'     => array(Rbac::OP_QA_QUESTION_UPDATE),
            ),
            array(
                'deny',
                'actions'   => array('update'),
            ),
            array(
                'allow',
                'actions'   => array('saveAnswer'),
                'roles'     => array(Rbac::OP_QA_ANSWER_CREATE),
            ),
            array(
                'deny',
                'actions'   => array('saveAnswer'),
            ),
        );
    }

    /**
     * Display latest questions
     */
    public function actionLatest()
    {
        // Get params
        $tag = $this->request->getParam('tag');

        // Get list of questions
        $criteria = new \EMongoCriteria;
        if (!empty($tag)) {
            $criteria->addCond('tagList', '==', mb_strtolower($tag));
        }
        $criteria->sort('dateCreated', \EMongoCriteria::SORT_DESC);
        $questions = Qa\Question::model()->findAll($criteria);

        // Render view
        $this->render('latest', array(
            'questions' => $questions,
        ));
    }

    /**
     * View a given question
     *
     * @param string $id
     */
    public function actionView($id)
    {
        // Get the question
        $question = Qa\Question::model()->findByPk(new \MongoId($id));
        if ($question === null) {
            $this->httpException(404);
        }

        // Get answers
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('questionId', '==', $id)
            ->sort('dateCreated', \EMongoCriteria::SORT_ASC);
        $answers = Qa\Answer::model()->findAll($criteria);

        // Render view
        $this->render('view', array(
            'question'  => $question,
            'answers'   => $answers,
        ));
    }

    /**
     * Ask a question
     */
    public function actionAsk()
    {
        // Check user to be loggedin
        if (\yii::app()->user->isGuest) {
            $this->redirect('/auth/login');
        }

        // Get params
        $id = $this->request->getParam('id');

        // Get question
        if (empty($id)) {
            $question = new Qa\Question();
        } else {
            $question = Qa\Question::model()->findByPk(new \MongoId($id));
            if ($question === null) {
                $this->httpException(404);
            }
        }

        // Render view
        $this->render('ask', array(
            'question' => $question
        ));
    }

    /**
     * Save a question
     */
    public function actionSave()
    {
        // Get params
        $id         = $this->request->getParam('id');
        $title      = $this->request->getParam('title');
        $content    = $this->request->getParam('content');
        $tagList    = $this->request->getParam('tagList');

        // Get question
        if (empty($id)) {
            $question = new Qa\Question();
        } else {
            $question = Qa\Question::model()->findByPk(new \MongoId($id));
            if ($question === null) {
                $this->httpException(404);
            }
        }

        // Save question
        $question->setAttributes(array(
            'userId'    => \yii::app()->user->id,
            'title'     => $title,
            'content'   => $content,
            'tagList'   => explode(',', $tagList),
        ), false);
        $question->save();

        // Render json
        $this->renderJson(array(
            'errors'    => $question->hasErrors() ? $question->getErrors() : false,
            'url'       => $this->createUrl('view', array('id' => $question->_id)),
        ));
    }

    /**
     * Give an answer to the question
     */
    public function actionAnswer()
    {
        // Get params
        $questionId = $this->request->getParam('questionId');
        $content    = $this->request->getParam('content');

        // Create answer
        $answer = new Qa\Answer();
        $answer->setAttributes(array(
            'userId'        => \yii::app()->user->id,
            'questionId'    => $questionId,
            'content'       => $content,
        ), false);
        $answer->save();

        // Render json
        $this->renderJson(array(
            'errors'        => $answer->hasErrors() ? $answer->getErrors() : false,
            'answerHtml'    => $this->renderPartial('partial/answer', array('answer' => $answer), true),
            'answerCount'   => \yii::t('app', '{n} Answer|{n} Answers', $answer->question->answerCount)
        ));
    }

    /**
     * Renders json list of tags
     */
    public function actionTagList()
    {
        // Get params
        $q      = mb_strtolower($this->request->getParam('q', ''));
        $limit  = (int)$this->request->getParam('page_limit', 10);

        // Get list of tags
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('name', '==', new \MongoRegex('/^' . preg_quote($q) . '/'))
            ->limit($limit)
            ->sort('name', \EMongoCriteria::SORT_ASC);
        $tags = Qa\Tag::model()->findAll($criteria);

        // Prepare tags for json
        $jsonTags = array();
        foreach ($tags as $tag) {
            $jsonTags[] = array(
                'id'    => $tag->name,
                'text'  => $tag->name
            );
        }

        // Render json
        $this->renderJson(array(
            'tags' => $jsonTags,
        ));
    }

}
