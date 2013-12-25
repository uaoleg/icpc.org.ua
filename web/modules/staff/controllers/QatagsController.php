<?php

namespace web\modules\staff\controllers;

use \common\models\Qa;

class QatagsController extends \web\modules\staff\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'all';

        // Set active main menu item
        $this->setNavActiveItem('main', 'qa');
    }

    /**
     * Display the full tag list
     */
    public function actionAll()
    {
        // Get list of tags
        $criteria = new \EMongoCriteria();
        $criteria->sort('name', \EMongoCriteria::SORT_ASC);
        $tags = Qa\Tag::model()->findAll($criteria);

        // Render view
        $this->render('all', array(
            'tags' => $tags,
        ));
    }

    /**
     * Manage tag
     */
    public function actionManage()
    {
        // Get params
        $id = $this->request->getParam('id');

        // Get tag
        if (empty($id)) {
            $tag = new Qa\Tag();
        } else {
            $tag = Qa\Tag::model()->findByPk(new \MongoId($id));
            if ($tag === null) {
                $this->httpException(404);
            }
        }

        // Save tag
        if ($this->request->isPostRequest) {

            // Get params
            $name = $this->request->getPost('name');
            $desc = $this->request->getPost('desc');

            // Save changes
            $tag->setAttributes(array(
                'name'  => $name,
                'desc'  => $desc,
            ), false);
            $tag->save();

            // Render json
            $this->renderJson(array(
                'errors' => $tag->hasErrors() ? $tag->getErrors() : false,
            ));

        }

        // Manage page
        else {

            // Render view
            $this->render('manage', array(
                'tag' => $tag,
            ));
        }
    }

}