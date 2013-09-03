<?php

namespace common\ext\Message;

/**
 * Translation message source
 */
class Source extends \CMessageSource
{

    /**
     * Loads the message translation for the specified language and category
     *
     * @param string $category
     * @param string $language
     * @return array
     */
    protected function loadMessages($category, $language)
    {
        $messages = $this->_loadFromDb($category, $language);
        return $messages;
    }

    /**
     * Load translations from DB
     *
     * @param string $category
     * @param string $language
     * @return array
     */
    protected function _loadFromDb($category, $language)
    {
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('category', '==', $category)
            ->addCond('language', '==', $language);
        $itemList = Item::model()->findAll($criteria);

        $messages = array();
        foreach ($itemList as $item) {
            $messages[$item->message] = $item->translation;
        }

        return $messages;
    }

}