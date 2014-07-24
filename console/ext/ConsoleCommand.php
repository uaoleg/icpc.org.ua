<?php

namespace console\ext;

class ConsoleCommand extends \CConsoleCommand
{

    /**
     * Category for logger
     */
    const LOG_CATEGORY = 'console';

    /**
     * Name of the current action
     * @var string
     */
    protected $_action;

    /**
     * List of current options
     * @var array
     */
    protected $_options;

    /**
     * List of current args
     * @var array
     */
    protected $_args;

    /**
     * Backtrace
     * @var array
     */
    protected $_backtrace;

    /**
     * Stack of widgets
     * @var array
     */
    protected $_widgetStack = array();

    /**
     * Initializes the command object
     */
    public function init()
    {
        parent::init();

        // Set default theme
        \yii::app()->setTheme('default');

        // Init $_SESSION variable
        if (!isset($_SESSION)) {
            $_SESSION = array();
        }

        // Init log router
        \yii::app()->log;
    }

    /**
	 * Executes the command
     *
	 * @param array $args command line parameters for this command.
	 */
	public function run($args)
	{
		list($this->_action, $this->_options, $this->_args) = $this->resolveRequest($args);

        parent::run($args);
    }

    /**
     * Get params of the current command
     *
     * @param bool $toString
     * @return array
     */
    public function getParams($toString = false)
    {
        if ($toString) {
            $params  = "";
            $params .= "Command: " . $this->getName() . " \n";
            $params .= "Action: $this->_action \n";
            $params .= "Options: " . print_r($this->_options, true) ." \n";
            $params .= "Args: " . print_r($this->_args, true) ." \n";
        } else {
            $params = array(
                'command'   => $this->getName(),
                'action'    => $this->_action,
                'options'   => $this->_options,
                'args'      => $this->_args,
            );
        }

        return $params;
    }

    /**
     * Set exception and error handlers for cron task actions
     */
    protected function _setExceptionAndErrorHandlersForCronTask()
    {
        set_exception_handler(array($this, 'handleExceptionForCronTask'));
        set_error_handler(array($this, 'handleErrorForCronTask'), error_reporting());
        register_shutdown_function(array($this, 'shutdown'));
    }

	/**
	 * Handles uncaught PHP exceptions.
	 *
	 * @param Exception $exception exception that is not caught
	 */
    public function handleExceptionForCronTask($exception, $endApplication = true)
    {
        // Disable error capturing to avoid recursive errors
        restore_error_handler();
        restore_exception_handler();

        // Log exception message
        $logMsg = "Cron task exception: \n";
        $logMsg .= $this->getParams(true);
        $logMsg .= get_class($exception) . "\n";
        $logMsg .= $exception->getMessage().' ('.$exception->getFile().':'.$exception->getLine().')' . "\n";
        $logMsg .= $exception->getTraceAsString();
        \yii::log($logMsg, \CLogger::LEVEL_ERROR, static::LOG_CATEGORY);

        // Display message
        \yii::app()->displayException($exception);

        // End application
        if ($endApplication) {
            try {
                \yii::app()->end();
            } catch (Exception $e) {
                exit(1);
            }
        }
    }

	/**
	 * Handles PHP execution errors such as warnings, notices
	 *
	 * @param integer $code the level of the error raised
	 * @param string  $message the error message
	 * @param string  $file the filename that the error was raised in
	 * @param integer $line the line number the error was raised at
     * @param array   $trace custom backtrace
	 */
    public function handleErrorForCronTask($code, $message, $file, $line, $trace = null)
    {
        if ((!$code) || (!error_reporting())) return;

        // Disable error capturing to avoid recursive errors
        restore_error_handler();
        restore_exception_handler();

        // Log error message
        $logMsg = "Cron task error [$code]: \n";
        $logMsg .= "$message \n";
        $logMsg .= "File: $file \n";
        $logMsg .= "Line: $line \n";
        $logMsg .= $this->getParams(true);
        $logMsg .= "Stack trace: \n";
//        if ($trace === null)
            $trace = debug_backtrace();
        // Skip the first 3 stacks as they do not tell the error position
        if (count($trace) > 3)
            $trace = array_slice($trace, 3);
        foreach ($trace as $i => $t) {
            if (!isset($t['file']))
                $t['file'] = 'unknown';
            if (!isset($t['line']))
                $t['line'] = 0;
            if (!isset($t['function']))
                $t['function'] = 'unknown';
            $logMsg .= "#$i {$t['file']}({$t['line']}): ";
            if (isset($t['object']) && is_object($t['object']))
                $logMsg .= get_class($t['object']).'->';
            $logMsg .= "{$t['function']}()\n";
        }
        \yii::log($logMsg, \CLogger::LEVEL_ERROR, static::LOG_CATEGORY);

        // Display message
        \yii::app()->displayError($code, $message, $file, $line);

        // End application
        try {
            \yii::app()->end();
        } catch (Exception $e) {
            exit(1);
        }
    }

    /**
     * Shutdown action
     */
    public function shutdown()
    {
//        unregister_tick_function(array($this, 'tickHandler'));
        $error = error_get_last();
        if ($error) {
            $this->handleErrorForCronTask(
                $error['type'], $error['message'], $error['file'], $error['line'],
                $this->_backtrace
            );
            die();
        }
    }

    /**
     * Tick handler
     */
    public function tickHandler()
    {
        $this->_backtrace = debug_backtrace(0);
    }

	/**
	 * Provides the command description
	 * @return string
	 */
	public function getHelp()
	{
        $help = "\n";;
        $help .= "HELP\n";
		$help .= '  Usage: '.$this->getCommandRunner()->getScriptName().' '.$this->getName();

        // Add option list
		$options = $this->getOptionHelp();
        if (count($options)) {
            $help .= " <action>\nActions:\n";
            foreach ($options as $option)
                $help .= '    ' . $option . "\n";
        }

        $help .= "\n\n";

		return $help;
	}

	/**
	 * This method is invoked right before an action is to be executed
     *
	 * @param string $action the action name
	 * @param array $params the parameters to be passed to the action method.
	 * @return boolean whether the action should be executed.
	 */
    public function beforeAction($action, $params)
    {
        echo "\n";

        return true;
    }

	/**
	 * This method is invoked right after an action finishes execution
	 *
	 * @param string $action the action name
	 * @param array $params the parameters to be passed to the action method.
     * @param int $exitCode the application exit code returned by the action method.
	 * @return int application exit code (return value is available since version 1.1.11)
	 */
	protected function afterAction($action, $params, $exitCode = 0)
	{
        echo "\n\n";
	}

    /**
     * Print text and log it with trace level
     *
     * @param string $text
     * @param bool   $print
     */
    public function traceText($text, $print = true)
    {
        if ($print)
            echo $text . "\n";
        $category = static::LOG_CATEGORY . '.' . get_class($this) . '.' . $this->_action;
        \yii::log($text, \CLogger::LEVEL_TRACE, $category);
    }

    /**
     * Get colored text
     *
     * @param string $text
     * @param string $color
     * @param string $backgroundColor
     * @return string
     */
    public function colorizeText($text, $color = null, $backgroundColor = null)
    {
        $coloredText = '';

        // Text color list
        $textColorList = array(
            'black'        => '0;30',
            'dark_gray'    => '1;30',
            'blue'         => '0;34',
            'light_blue'   => '1;34',
            'green'        => '0;32',
            'light_green'  => '1;32',
            'cyan'         => '0;36',
            'light_cyan'   => '1;36',
            'red'          => '0;31',
            'light_red'    => '1;31',
            'purple'       => '0;35',
            'light_purple' => '1;35',
            'brown'        => '0;33',
            'yellow'       => '1;33',
            'light_gray'   => '0;37',
            'white'        => '1;37'
        );

        // Background color list
        $backgroundColorList = array(
            'black'      => '40',
            'red'        => '41',
            'green'      => '42',
            'yellow'     => '43',
            'blue'       => '44',
            'magenta'    => '45',
            'cyan'       => '46',
            'light_gray' => '47'
        );

        // Set text color
        if (isset($textColorList[$color]))
            $coloredText .= "\033[" . $textColorList[$color] . "m";

        // Set background color
        if (isset($backgroundColorList[$backgroundColor]))
            $coloredText .= "\033[" . $backgroundColorList[$backgroundColor] . "m";

        // Add string and end coloring
        $coloredText .=  $text . "\033[0m";

        // Return colored text
        return $coloredText;
    }

    /**
     * Get number of running processes of current command
     *
     * @return int
     */
    public function getRunningProcessesCount()
    {
        $output = array();
        $cmd = "ps -ef | grep -v grep | grep \"{$this->getName()} {$this->_action}\"";
        exec($cmd, $output);
        return count($output);
    }

    /**
     * Creates a widget and initializes it.
     * This method first creates the specified widget instance.
     * It then configures the widget's properties with the given initial values.
     * At the end it calls {@link CWidget::init} to initialize the widget.
     * Starting from version 1.1, if a {@link CWidgetFactory widget factory} is enabled,
     * this method will use the factory to create the widget, instead.
     * @param string $className class name (can be in path alias format)
     * @param array $properties initial property values
     * @return CWidget the fully initialized widget instance.
     */
    public function createWidget($className, array $properties = array())
    {
        $widget = \yii::app()->getWidgetFactory()->createWidget($this, $className, $properties);
        $widget->init();
        return $widget;
    }


    /**
     * Creates a widget and executes it.
     * @param string $className the widget class name or class in dot syntax (e.g. application.widgets.MyWidget)
     * @param array $properties list of initial property values for the widget (Property Name => Property Value)
     * @param boolean $captureOutput whether to capture the output of the widget. If true, the method will capture
     * and return the output generated by the widget. If false, the output will be directly sent for display
     * and the widget object will be returned. This parameter is available since version 1.1.2.
     * @return mixed the widget instance when $captureOutput is false, or the widget output when $captureOutput is true.
     */
    public function widget($className, array $properties = array(), $captureOutput = false)
    {
        if ($captureOutput) {
            ob_start();
            ob_implicit_flush(false);
            $widget=$this->createWidget($className, $properties);
            $widget->run();
            return ob_get_clean();
        } else {
            $widget=$this->createWidget($className, $properties);
            $widget->run();
            return $widget;
        }
    }

    /**
     * Creates a widget and executes it.
     * This method is similar to {@link widget()} except that it is expecting
     * a {@link endWidget()} call to end the execution.
     * @param string $className the widget class name or class in dot syntax (e.g. application.widgets.MyWidget)
     * @param array $properties list of initial property values for the widget (Property Name => Property Value)
     * @return CWidget the widget created to run
     * @see endWidget
     */
    public function beginWidget($className, array $properties = array())
    {
        $widget=$this->createWidget($className, $properties);
        $this->_widgetStack[] = $widget;
        return $widget;
    }

    /**
     * Ends the execution of the named widget.
     * This method is used together with {@link beginWidget()}.
     * @param string $id optional tag identifying the method call for debugging purpose.
     * @return CWidget the widget just ended running
     * @throws CException if an extra endWidget call is made
     * @see beginWidget
     */
    public function endWidget($id = '')
    {
        if (($widget=array_pop($this->_widgetStack)) !== null) {
            $widget->run();
            return $widget;
        } else {
            throw new CException(\yii::t('app', '{controller} has an extra endWidget({id}) call in its view.', array(
                '{controller}'  => get_class($this),
                '{id}'          => $id,
            )));
        }
    }

}