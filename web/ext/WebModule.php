<?php

namespace web\ext;

class WebModule extends \CWebModule
{

   /**
    * Init
    */
   public function init()
   {
       parent::init();

       // Set default controller to all modules
       $this->defaultController = 'index';

       // Set view and layout path
       $viewPath = \yii::getPathOfAlias('web.modules.' . $this->getId() . '.views');
       $this->setViewPath($viewPath . '/scripts');
       if (is_dir($viewPath . '/layouts')) {
           $this->setLayoutPath($viewPath . '/layouts');
       } else {
           $this->setLayoutPath(\yii::app()->layoutPath);
       }
   }

}