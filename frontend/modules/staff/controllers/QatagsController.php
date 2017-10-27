<?php

namespace frontend\modules\staff\controllers;

use \common\models\Qa;

class QatagsController extends \frontend\modules\staff\ext\Controller
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
        $tags = Qa\Tag::find()
            ->orderBy('name')
            ->all()
        ;

        // Render view
        return $this->render('all', array(
            'tags' => $tags,
        ));
    }

    /**
     * Manage tag
     */
    public function actionManage()
    {
        // Get params
        $id = \yii::$app->request->get('id');

        // Get tag
        if (empty($id)) {
            $tag = new Qa\Tag();
        } else {
            $tag = Qa\Tag::findOne($id);
            if ($tag === null) {
                $this->httpException(404);
            }
        }

        // Save tag
        if (\yii::$app->request->isPost) {

            // Get params
            $name = \yii::$app->request->post('name');
            $desc = \yii::$app->request->post('desc');

            // Save changes
            $tag->setAttributes(array(
                'name'  => $name,
                'desc'  => $desc,
            ), false);
            $tag->save();

            // Render json
            return $this->renderJson(array(
                'errors' => $tag->hasErrors() ? $tag->getErrors() : false,
            ));

        }

        // Manage page
        else {

            // Render view
            return $this->render('manage', array(
                'tag' => $tag,
            ));
        }
    }

    /**
     * Delete tag
     */
    public function actionDelete()
    {
        if (\yii::$app->request->isPost) {

            // Get params
            $id = \yii::$app->request->post('id');

            // Delete tag
            $tagToDelete = Qa\Tag::findOne($id);
            $tagToDelete->delete();

            // Render json
            return $this->renderJson(array(
                'errors' => $tagToDelete->hasErrors() ? $tagToDelete->getErrors() : false,
            ));
        }
    }

}