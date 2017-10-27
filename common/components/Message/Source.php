<?php

namespace common\components\Message;

use \yii\helpers\ArrayHelper;

/**
 * Translation message source
 */
class Source extends \yii\i18n\DbMessageSource
{

    /**
     * Loads the messages from database.
     * You may override this method to customize the message storage in the database.
     * @param string $category the message category.
     * @param string $language the target language.
     * @return array the messages loaded from database.
     */
    protected function loadMessagesFromDb($category, $language)
    {
        $itemList = Item::find()
            ->select('message, translation')
            ->andWhere([
                'category'  => $category,
                'language'  => mb_substr($language, 0, 2),
            ])
            ->asArray()
            ->all()
        ;
        return ArrayHelper::map($itemList, 'message', 'translation');
    }

}
