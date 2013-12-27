<?php

use \common\ext\Message;

class MessageCommand extends \console\ext\ConsoleCommand
{

    /**
     * Get command help
     *
     * @return string
     */
	public function getHelp()
	{
		return <<<EOD
USAGE
  yiic message

DESCRIPTION
  This command searches for messages to be translated in the specified
  source files and compiles them into PHP arrays as message source.

EOD;
	}

	/**
	 * Parse translations
	 */
	public function actionParse()
	{
        // Get list of files
        $sourcePathPhp = \yii::app()->basePath . '/../';
        $sourcePathJs  = \yii::app()->basePath . '/../web/www/js/';
		$optionsPhp = $optionsJs = array(
            'exclude' => array(
                '.svn',
                '.gitignore',
                'yiilite.php',
                'yiit.php',
                '/common/lib',
                '/tests',
                '/web/www',
            ),
            'fileTypes' => array(),
        );
        $optionsPhp['fileTypes'] = array('php');
        $optionsJs['fileTypes'] = array('js');
		$fileListPhp = \CFileHelper::findFiles(realpath($sourcePathPhp), $optionsPhp);
        $fileListJs = \CFileHelper::findFiles(realpath($sourcePathJs), $optionsJs);

        // Extract messages from each file
		$messageList = array();
		foreach ($fileListPhp as $file) {
			$messageList = array_merge_recursive($messageList, $this->_extractMessages($file, 'Yii::t'));
        }
		foreach ($fileListJs as $file) {
			$messageList = array_merge_recursive($messageList, $this->_extractMessages($file, '_t'));
        }

        // Save messages to DB
        echo "Saving messages to DB...\n";
        $languages = array_keys(\yii::app()->params['languages']);
		foreach ($languages as $language) {
			foreach ($messageList as $category => $categoryMessageList) {
                $_messageIndexList = array();
                // Save each message to DB
                foreach ($categoryMessageList as $message) {
                    $_messageIndexList[] = $message;
                    $item = new Message\Item();
                    $item->setAttributes(array(
                        'category'  => $category,
                        'language'  => $language,
                        'message'   => $message,
                    ), false);
                    $item->save();
                }
                // Delete old messages
                $criteria = new \EMongoCriteria();
                $criteria
                    ->addCond('category', '==', $category)
                    ->addCond('language', '==', $language)
                    ->addCond('message', 'notin', $_messageIndexList);
                Message\Item::model()->deleteAll($criteria);
			}
		}

        // Done
        echo "Done.\n";
	}

    /**
     * Generate translation messages for js files
     */
    public function actionGenerateJs()
    {
        // Get all messages for js
        $jsCategory = Message\Item::JS_CATEGORY;
        $messages = Message\Item::model()->findAllByAttributes(array(
            'category' => $jsCategory,
        ));
        $translations = array();
        foreach ($messages as $item) {
            $translations[$jsCategory][$item->language][$item->message] = array(
                'translation' => $item->translation,
            );
        }

        // Encode non-empty result
        if (count($translations) > 0) {
            $translationsJson = 'translations = ' . json_encode($translations);

        } else {
            $translationsJson = 'translations = {}';
        }
        file_put_contents(\yii::getPathOfAlias('web.www.js') . "/translations.js", $translationsJson);
    }

    /**
     * Extract messages from file
     *
     * @param string $fileName
     * @param string $translator
     * @return array
     */
	protected function _extractMessages($fileName, $translator)
	{
		echo "Extracting messages from $fileName...\n";
		$subject = file_get_contents($fileName);
		$n = preg_match_all('/\b' . $translator . '\s*\(\s*(\'.*?(?<!\\\\)\'|".*?(?<!\\\\)")\s*,\s*(\'.*?(?<!\\\\)\'|".*?(?<!\\\\)")\s*[,\)]/si', $subject, $matches, PREG_SET_ORDER);
		$messages = array();
		for ($i = 0; $i < $n; ++$i) {
			if (($pos = strpos($matches[$i][1], '.')) !== false) {
				$category = substr($matches[$i][1], $pos + 1, -1);
            } else {
				$category = substr($matches[$i][1], 1, -1);
            }
			$message = $matches[$i][2];
			$messages[$category][] = eval("return $message;");  // use eval to eliminate quote escape
		}
		return $messages;
	}

}