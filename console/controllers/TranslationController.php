<?php

namespace console\controllers;

use \common\components\Message;
use \yii\helpers\FileHelper;

class TranslationController extends BaseController
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
		$optionsPhp = $optionsJs = array(
            'exclude' => array(
                '.svn',
                '.gitignore',
                'yiilite.php',
                'yiit.php',
                '/tests',
                '/web',
            ),
            'fileTypes' => array(),
        );
        $optionsPhp['fileTypes'] = array('php');
        $optionsJs['fileTypes'] = array('js');

        // Extract messages from each file
		$messageList = array();
		foreach (FileHelper::findFiles(\yii::getAlias('@common'), $optionsPhp) as $file) {
			$messageList = array_merge_recursive($messageList, $this->_extractMessages($file, '\yii::t'));
        }
		foreach (FileHelper::findFiles(\yii::getAlias('@frontend'), $optionsPhp) as $file) {
			$messageList = array_merge_recursive($messageList, $this->_extractMessages($file, '\yii::t'));
        }
		foreach (FileHelper::findFiles(\yii::getAlias('@frontend/assets/js'), $optionsJs) as $file) {
			$messageList = array_merge_recursive($messageList, $this->_extractMessages($file, '_t'));
        }

        // Save messages to DB
        echo "Saving messages to DB...\n";
        $languages = array_keys(\yii::$app->params['languages']);
		foreach ($languages as $language) {
			foreach ($messageList as $category => $categoryMessageList) {
                $_messageIndexList = array();
                // Save each message to DB
                foreach ($categoryMessageList as $message) {
                    $_messageIndexList[] = $message;
                    $item = new Message\Item([
                        'category'  => $category,
                        'language'  => $language,
                        'message'   => $message,
                    ]);
                    $item->save();
                }
                // Delete old messages
                Message\Item::deleteAll([
                    'AND',
                    'category = :category',
                    'language = :language',
                    ['NOT IN', 'message', $_messageIndexList],
                ], [
                    ':category' => $category,
                    ':language' => $language,
                ]);
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
        $messages = Message\Item::findAll(['category' => $jsCategory]);
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
        file_put_contents(\yii::getAlias('@frontend/web/js') . "/translations.js", $translationsJson);
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