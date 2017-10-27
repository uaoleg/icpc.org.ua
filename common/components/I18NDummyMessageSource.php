<?php

namespace common\components;

class I18NDummyMessageSource extends \yii\i18n\PhpMessageSource
{

    /**
     * Alwats returns empty array
     *
     * @param string $category the message category
     * @param string $language the target language
     * @return array
     */
    protected function loadMessages($category, $language)
    {
        return [];
    }

}
