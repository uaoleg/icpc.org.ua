<?php

namespace console\controllers;

use \common\models\BaseActiveRecord;
use \yii\helpers\ArrayHelper;
use \yii\helpers\Console;
use \PHPHtmlParser\Dom;

class BaseController extends \yii\console\Controller
{

    /**
     *
     * @var string
     */
    public $dbName;

    /**
     * Guzzle HTTP client
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * @var Dom
     */
    protected $parser;

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Support cyrillic on windows
        if ($this->isWindows()) {
            system("chcp 65001");
        }
    }

    /**
     * Init Guzzle client
     * @param array $config
     */
    protected function guzzleInit(array $config = [])
    {
        // Guzzle configuration
        $defaultConfig = [
            'cookies'   => true,
            'timeout'   => 30,
            'headers'   => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36',
            ],
        ];

        // Init guzzle
        $this->guzzle = new \GuzzleHttp\Client(ArrayHelper::merge($defaultConfig, $config));
    }

    /**
     * Returns Guzzle response parsed into HTML
     * @link https://github.com/8p/GuzzleBundle/issues/48
     * @param \GuzzleHttp\Psr7\Response $res
     * @return Dom
     */
    protected function guzzleParseHtml(\GuzzleHttp\Psr7\Response $res)
    {
        // Get response body
        $body = $res->getBody();
        if ($body->isSeekable()) {
            $body->rewind();
        }
        $contents = $body->getContents();

        // Remove all dirty hacks before <body> tag
        // Mainly is used for http://feerie.com.ua
        $contents = mb_substr($contents, mb_strpos($contents, '<body'));

        // Parse HTML
        if (!$this->parser) {
            $this->parser = new Dom;
        }
        $html = $this->parser->load($contents);

        return $html;
    }

    /**
     * Returns the names of valid options for the action (id)
     * @param string $actionID the action id of the current request
     * @return string[] the names of the options valid for the action
     */
    public function options($actionID)
    {
        return ArrayHelper::merge(parent::options($actionID), [
            'dbName',
        ]);
    }

    /**
     * This method is invoked right before an action is executed.
     * @param Action $action the action to be executed.
     * @return bool whether the action should continue to run.
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Set non default database, e.g. "dbtests"
        if ($this->dbName) {
            \yii::$app->set('db', \yii::$app->{$this->dbName});
        }

        return true;
    }

    /**
     * This method is invoked right after an action is executed
     * @param Action $action the action just executed.
     * @param mixed $result the action return result.
     * @return mixed the processed action result.
     */
    public function afterAction($action, $result)
    {
        echo "\n\n";

        return parent::afterAction($action, $result);
    }

    /**
     * Fancy display of AR errors
     * @param BaseActiveRecord $object
     */
    public function printErrors(BaseActiveRecord $object)
    {
        foreach ($object->errors as $attrName => $attrErrors) {
            $this->stdout("{$this->ansiFormat('Error:', Console::FG_RED)} {$attrName}\n");
            foreach ($attrErrors as $error) {
                echo "   - {$error}\n";
            }
        }
    }

    /**
     * Fancy display of errors and exceptions
     * @param \Throwable $e
     */
    public function printException(\Throwable $e)
    {
        $output =
            "{$this->ansiFormat('Exception:', Console::FG_RED)} {$e->getMessage()}\n\n" .
            " in {$e->getFile()}:{$e->getLine()}\n\n" .
            "Stack trace:\n"
        ;

        foreach ($e->getTrace() as $i => $trace) {
            $output .= "#{$i} ";
            if (isset($trace['file'])) {
                $output .= "{$trace['file']}({$trace['line']}): ";
            } else {
                $output .= "[internal function]: ";
            }
            if (isset($trace['class'])) {
                $output .= "{$trace['class']}->";
            }
            $output .= "{$trace['function']}()\n";
        }
        $output .= "\n";

        $this->stdout($output);
    }

    /**
     * Prints a string to STDOUT
     * @param string $string
     * @return string
     */
    public function stdout($string)
    {
        // Prepend time
        $date =  date('Y-m-d H:i:s');
        $string = $this->ansiFormat("[{$date}] ", Console::FG_GREY) . $string;

        return parent::stdout($string);
    }

    /**
     * Check if env OS is Windows
     * @return bool
     */
    protected function isWindows()
    {
        $os = getenv('OS');
        $isWindows = (stripos($os, 'windows') !== false);
        return $isWindows;
    }

}
