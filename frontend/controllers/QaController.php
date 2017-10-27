<?php

namespace frontend\controllers;

use \common\components\Rbac;
use \common\helpers\StringHelper;
use \common\models\Qa;
use \yii\helpers\Url;

class QaController extends BaseController
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
        $tag = mb_strtolower(\yii::$app->request->get('tag'));

        // Get list of questions
        $questions = Qa\Question::find()
            ->alias('question')
            ->orderBy('question.timeCreated DESC')
        ;

        // Filter by tag
        if (!empty($tag)) {
            $questions
                ->innerJoin(['rel' => Qa\QuestionTagRel::tableName()], 'rel.questionId = question.id')
                ->innerJoin(['tag' => Qa\Tag::tableName()], 'tag.id = rel.tagId')
                ->andWhere(['tag.name' => $tag])
            ;
        }

        // Get list of tags
        $tags = Qa\Tag::find()
            ->orderBy('name')
            ->all()
        ;

        // Render view
        return $this->render('latest', array(
            'questions' => $questions->all(),
            'tags'      => $tags,
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
        $question = Qa\Question::findOne($id);
        if ($question === null) {
            $this->httpException(404);
        }

        // Get answers
        $answers = Qa\Answer::find()
            ->andWhere(['questionId' => $id])
            ->orderBy('timeCreated')
            ->all()
        ;

        // Render view
        return $this->render('view', array(
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
        if (\yii::$app->user->isGuest) {
            $this->redirect('/auth/login');
        }

        // Get params
        $id = \yii::$app->request->get('id');

        // Get question
        if (empty($id)) {
            $question = new Qa\Question();
        } else {
            $question = Qa\Question::findOne($id);
            if ($question === null) {
                $this->httpException(404);
            }
        }

        // Get tags
        $tags = Qa\Tag::find()
            ->orderBy('name')
            ->all()
        ;

        // Render view
        return $this->render('ask', array(
            'question' => $question,
            'tags'     => $tags
        ));
    }

    /**
     * Save a question
     */
    public function actionSave()
    {
        // Get params
        $id         = \yii::$app->request->post('id');
        $title      = \yii::$app->request->post('title');
        $content    = \yii::$app->request->post('content');
        $tagList    = \yii::$app->request->post('tagList');

        // Get question
        if (empty($id)) {
            $question = new Qa\Question();
        } else {
            $question = Qa\Question::findOne($id);
            if ($question === null) {
                $this->httpException(404);
            }
        }

        // Save question
        $question->setAttributes(array(
            'userId'    => \yii::$app->user->id,
            'title'     => $title,
            'content'   => $content,
            'tagList'   => $tagList,
        ), false);
        $question->save();

        // Render json
        return $this->renderJson(array(
            'errors'    => $question->hasErrors() ? $question->getErrors() : false,
            'url'       => Url::toRoute(['view', 'id' => $question->id]),
        ));
    }

    /**
     * Give an answer to the question
     */
    public function actionAnswer()
    {
        // Get params
        $questionId = \yii::$app->request->post('questionId');
        $content    = \yii::$app->request->post('content');

        // Create answer
        $answer = new Qa\Answer();
        $answer->setAttributes(array(
            'userId'        => \yii::$app->user->id,
            'questionId'    => $questionId,
            'content'       => $content,
        ), false);
        $answer->save();

        // Render json
        return $this->renderJson(array(
            'errors'        => $answer->hasErrors() ? $answer->getErrors() : false,
            'answerHtml'    => $this->renderPartial('partial/answer', array('answer' => $answer)),
            'answersCount'  => \yii::t('app', '{0, plural, one{# Answer} few{# Answers} many{# Answers} other{# Answers}}', $answer->question->answersCount)
        ));
    }

    /**
     * Renders json list of tags
     */
    public function actionTagList()
    {
        // Get params
        $q      = mb_strtolower(\yii::$app->request->get('q', ''));
        $limit  = (int)\yii::$app->request->get('page_limit', 10);

        // Get list of tags
        $tags = Qa\Tag::find()
            ->andWhere('name REGEXP :name', [
                ':name' => StringHelper::dbFindRegexp($q),
            ])
            ->limit($limit)
            ->orderBy('name')
            ->all()
        ;

        // Prepare tags for json
        $jsonTags = array();
        foreach ($tags as $tag) {
            $jsonTags[] = array(
                'id'    => $tag->name,
                'text'  => $tag->name
            );
        }

        // Render json
        return $this->renderJson(array(
            'tags' => $jsonTags,
        ));
    }

}
