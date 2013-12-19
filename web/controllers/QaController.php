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
        // Return rules
        return array(
            array(
                'allow',
                'actions' => array('create'),
                'roles' => array(Rbac::OP_QA_QUESTION_CREATE),
            ),
            array(
                'allow',
                'actions' => array('addComment'),
                'roles' => array(Rbac::OP_QA_COMMENT_CREATE),
            ),
            array(
                'allow',
                'actions' => array('update'),
                'roles' => array(Rbac::OP_QA_QUESTION_UPDATE),
            ),
            array(
                'allow',
                'actions' => array('saveAnswer'),
                'roles' => array(Rbac::OP_QA_ANSWER_CREATE),
            ),
            array(
                'allow',
                'actions' => array('latest', 'view', 'tag'),
                'users' => array('*'),
            ),
            array(
                'deny',
            )
        );
    }

    public function actionLatest()
    {
        $criteria = new \EMongoCriteria;
        $criteria->sort('dateCreated', \EMongoCriteria::SORT_DESC);
        $pages = new \CPagination(Qa\Question::model()->count());
        $pages->pageSize = 10;
        $q = Qa\Question::model()->findAll($criteria);
        $this->render(
            'index',
            array(
                'q' => $q,
                'pages' => $pages,
                'tagMode' => false
            )
        );
    }

    public function actionView($id)
    {
        $question = Qa\Question::model()->findByPk(new \MongoId($id));

        $criteria = new \EMongoCriteria;
        $criteria
            ->addCond('questionId', '==', (string)$question->_id)
            ->setSort(array(
                'dateCreated' => \EMongoCriteria::SORT_DESC,
            ));
        $answers = Qa\Answer::model()->findAll($criteria);

        $this->render(
            'view',
            array(
                'question' => $question,
                'answers' => $answers ?: array(),
            )
        );
    }

    /**
     * Create a question
     */
    public function actionCreate()
    {
        $question = new Qa\Question();
        if ($this->request->isPostRequest) {
            $this->applyChanges(
                $question,
                array(
                    'title' => $this->request->getParam('title', ''),
                    'content' => $this->request->getParam('content', ''),
                    'tagList' => explode(',', $this->request->getParam('tagList', array())),
                    'answerCount' => 0,
                )
            );
        }
        $this->render(
            'create',
            array(
                'question' => $question
            )
        );
    }

    /**
     * Update a question
     *
     * @param string $id mondoDB record key
     */
    public function actionUpdate($id)
    {
        $question = Qa\Question::model()->findByPk(new \MongoId($id));
        if ($this->request->isPostRequest) {
            $this->applyChanges(
                $question,
                array(
                    'title' => $this->request->getParam('title', ''),
                    'content' => $this->request->getParam('content', ''),
                    'tagList' => explode(',', $this->request->getParam('tagList', array())),
                )
            );
        }
        $this->render(
            'update',
            array(
                'question' => $question,
            )
        );
    }

    /**
     * Create an answer to the question
     *
     * @param string $id mondoDB record key
     */
    public function actionSaveAnswer($id)
    {
        $content = $this->request->getParam('content', '');
        $this->applyChanges(
            new Qa\Answer(),
            array(
                'content' => $content,
                'questionId' => $id,
            ),
            function() use ($id) {
                $question = Qa\Question::model()->findByPk(new \MongoId($id));
                $question->answerCount = intval($question->answerCount) + 1;
                try {
                    if (!$question->save()) {
                        $this->renderJson(array(
                            'errors' => $question->getErrors
                        ));
                    }
                } catch (\Exception $e) {
                    $this->renderJson(array(
                        'error' => array(
                            'common' => $e->getMessage()
                        )
                    ));
                }
            }
        );
    }

    public function actionTag($id)
    {
        $criteria = new \EMongoCriteria();
        $criteria->addCond('tagList', '==', $id);
        $criteria->setLimit(10);
        $criteria->setSort(array(
            'dateCreated' => \EMongoCriteria::SORT_DESC
        ));
        $pages = new \CPagination(Qa\Question::model()->count());
        $pages->pageSize = 10;
        $q = Qa\Question::model()->findAll($criteria);
        $this->render(
            'index',
            array(
                'q' => $q,
                'pages' => $pages,
                'tagMode' => true,
                'tagName' => $id,
            )
        );
    }

    public function actionGetTags()
    {
        $q = mb_strtolower($this->request->getParam('q', ''));
        $page_limit = $this->request->getParam('page_limit', 10);
        $conditions = new \EMongoCriteria();
        $conditions->name = new \MongoRegex("/^" . preg_quote($q) . "/");
        $conditions->setLimit($page_limit);
        $conditions->setSort(array(
            'name' => \EMongoCriteria::SORT_ASC,
            'dateCreated' => \EMongoCriteria::SORT_ASC
        ));
        $tags = Qa\Tag::model()->findAll($conditions);
        $this->renderJson(
            array(
                'tags' => $this->simplifyData($tags),
            )
        );
    }

    public function actionAddComment()
    {
        $id = $this->request->getParam('id', '');
        $entity = $this->request->getParam('entity', 'question');
        $content = $this->request->getParam('content', '');
        $className = '\common\models\Qa\\' . \yii::app()->string->mb_ucfirst($entity);
        $model = $className::model()->findByPk(new \MongoId($id));
        if ($model && $this->request->isPostRequest) {
            $comment = new Qa\CommentMapper();
            $comment->setContent($content);
            if (!$comment->hasErrors()) {
                $model->comments[] = $comment->getData();
            } else {
                $_['status'] = 'error';
                $_['errors'] = $comment->getErrors();
                $this->renderJson($_);
            }
            $_['errors'] = array();
            try {
                if ($model->save()) {
                    $_['status'] = 'success';
                    $_['id'] = (string)$model->_id;
                } else {
                    $_['status'] = 'error';
                    $_['errors'] = $model->getErrors();
                }
            } catch (\Exception $e) {
                $_['status'] = 'error';
                $_['errors']['common'] = $e->getMessage();
            }
            $this->renderJson($_);
        }
        $this->renderJson(array(
            'errors' => array(
                'common' => \yii::t('app', 'Bad request')
            )
        ));
    }

    protected function simplifyData($data)
    {
        $res = array();
        if (!$data) {
            return array();
        }
        foreach ($data as $key => $value) {
            $res[] = array(
                //'id' => (string)$value->_id,
                'id' => $value->name,
                'text' => $value->name
            );
        }
        return $res;
    }
}