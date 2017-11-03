<?php

namespace common\components\Mailgun;


use yii\base\NotSupportedException;
use yii\helpers\VarDumper;
use yii\mail\BaseMessage;
use Mailgun\Messages\MessageBuilder;

/**
 * Message implements a message class based on Mailgun.
 */
class Message extends BaseMessage
{
    /**
     * @var MessageBuilder Mailgun message builder.
     */
    private $_messageBuilder;


    /**
     * @return MessageBuilder Mailgun message builder.
     */
    public function getMessageBuilder()
    {
        if (!is_object($this->_messageBuilder)) {
            $this->_messageBuilder = $this->createMessageBuilder();
        }

        return $this->_messageBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getCharset()
    {
        return 'utf8';
    }

    /**
     * @inheritdoc
     */
    public function setCharset($charset)
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return null;
    }

    /**
     * Sets the message sender.
     *
     * @param string|array $from sender email address.
     * You may specify sender name in addition to email address using format:
     * `[email => name]`.
     * If you don't set this parameter the application adminEmail parameter will
     * be used as the sender email address and the application name will be used
     * as the sender name.
     * @return Message
     */
    public function setFrom($from)
    {
        if (is_array($from)) {
            $address = key($from);
            $name = array_shift($from);
            $from = "{$name} <{$address}>";
        }

        $this->getMessageBuilder()->setFromAddress($from);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getReplyTo()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function setReplyTo($replyTo)
    {
        $this->getMessageBuilder()->setReplyToAddress($replyTo);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return !empty($message['to']) ? $message['to'] : null;
    }

    /**
     * @inheritdoc
     */
    public function setTo($to)
    {
        $this->getMessageBuilder()->addToRecipient($to);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCc()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return !empty($message['cc']) ? $message['cc'] : null;
    }

    /**
     * @inheritdoc
     */
    public function setCc($cc)
    {
        $this->getMessageBuilder()->addCcRecipient($cc);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBcc()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return !empty($message['bcc']) ? $message['bcc'] : null;
    }

    /**
     * @inheritdoc
     */
    public function setBcc($bcc)
    {
        $this->getMessageBuilder()->addBccRecipient($bcc);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return !empty($message['subject']) ? $message['subject'] : null;
    }

    /**
     * @inheritdoc
     */
    public function setSubject($subject)
    {
        $this->getMessageBuilder()->setSubject($subject);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTextBody($text)
    {
        $this->getMessageBuilder()->setTextBody($text);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setHtmlBody($html)
    {
        $this->getMessageBuilder()->setHtmlBody($html);

        return $this;
    }

    /**
     * Set mail view (body)
     * @param string $view
     * @param array  $params
     * @param string $layout
     * @return Message
     */
    public function setViewBody($view, array $params = [], $layout = 'mail')
    {
        $email = \yii::$app->email;
        $params['email'] = $this;
        $content = $email->view->render($view, $params, $email);
        $this->getMessageBuilder()->setHtmlBody(
            $email->view->render($email->htmlLayout, ['content' => $content, 'email' => $this], $email)
        );
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attach($fileName, array $options = [])
    {
        $attachmentName = !empty($options['fileName']) ? $options['fileName'] : null;
        $this->getMessageBuilder()->addAttachment("@{$fileName}", $attachmentName);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attachContent($content, array $options = [])
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function embed($fileName, array $options = [])
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function embedContent($content, array $options = [])
    {
        throw new NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        return VarDumper::dumpAsString($this->getMessageBuilder()->getMessage());
    }

    /**
     * Creates the Mailgun message builder.
     * @return MessageBuilder message builder.
     */
    protected function createMessageBuilder()
    {
        return new MessageBuilder;
    }
}
