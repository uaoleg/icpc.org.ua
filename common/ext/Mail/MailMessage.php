<?php

namespace common\ext\Mail;

\yii::import('common.lib.YiiMail.YiiMailMessage');

class MailMessage extends \YiiMailMessage
{

	/**
	* You may optionally set some message info using the paramaters of this
	* constructor.
	* Use {@link view} and {@link setBody()} for more control.
	*
	* @param string $subject
	* @param string $body
	* @param string $contentType
	* @param string $charset
	* @return Swift_Mime_Message
	*/
    public function __construct($subject = null, $body = null, $contentType = null, $charset = null)
    {
        parent::__construct($subject, $body, $contentType, $charset);
    }

    /**
     * Add recipient
     *
     * @param string $email
     * @return \common\ext\Mail\MailMessage
     */
    public function addTo($email)
    {
        parent::addTo($email);
        return $this;
    }

    /**
     * Set email sender
     *
     * @param string $email
     * @param string $name
     * @return \common\ext\Mail\MailMessage
     */
    public function setFrom($email, $name = null)
    {
        // Add Email name if it is specified
        if ($name !== null) {
            $email = array($email => $name);
        }
        parent::setFrom($email);
        return $this;
    }

    /**
     * Set mail subject
     *
     * @param string $subject
     * @return \common\ext\Mail\MailMessage
     */
    public function setSubject($subject)
    {
        parent::setSubject($subject);
        return $this;
    }

    /**
     * Set mail view (body)
     *
     * @param string $view
     * @param array  $data
     * @param string $layout
     * @return \common\ext\Mail\MailMessage
     */
    public function setView($view, array $data = array(), $layout = 'mail')
    {
        // Set view path
        $this->view = (string)$view;

        // Append this mail object to the data
        $data = array_merge($data, array(
            'mail' => $this,
        ));

        // If \yii::app()->controller doesn't exist create a dummy
        // controller to render the view (needed in the console app)
        if (isset(\yii::app()->controller)) {
            $controller = \yii::app()->controller;
        } else {
            $controller = new \CController('YiiMail');
        }

        // RenderPartial won't work with CConsoleApplication, so use
        // renderInternal - this requires that we use an actual path to the
        // view rather than the usual alias
        $viewPath = \yii::getPathOfAlias(\yii::app()->mail->viewPath . '.' . $this->view) . '.php';
        $content  = $controller->renderInternal($viewPath, $data, true);
        $layoutPath = \yii::app()->mail->layoutPath . DIRECTORY_SEPARATOR . $layout . '.php';
        $body = $controller->renderInternal($layoutPath, array_merge($data, array(
            'content' => $content,
        )), true);

        // Set message body
        $body = preg_replace('/\s\s+/', '', $body);
		$this->message->setBody($body, 'text/html', 'utf-8');

        return $this;
    }

    /**
     * Deprecate setBody() method
     *
     * @param mixed   $body
     * @param string  $contentType
     * @param string  $charset
     * @throws \Exception
     * @see setView()
     */
    /*public function setBody($body = '', $contentType = null, $charset = null)
    {
        throw new \Exception(\yii::t('app', 'Use setView() method instead of this one.'));
    }*/

}