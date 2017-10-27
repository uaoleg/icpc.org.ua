<?php

namespace yii\helpers;

use \common\models\BaseActiveRecord;

class Html extends BaseHtml
{

    /**
     * Generates an appropriate input ID for the specified attribute name or expression.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for explanation of attribute expression.
     * @return string the generated input ID
     */
    public static function getInputId($model, $attribute)
    {
        $id = parent::getInputId($model, $attribute);
        return "jsinput-{$id}-{$model->formId()}";
    }

    /**
     * The same as dropDownList()
     * Renders Bootstrap dropdown with select behaviour
     * @param string $attr
     * @param array $items
     * @param array $options
     * @return string
     */
    public static function activeBootstrapDropdownSelect(BaseActiveRecord $model, $attr, $items = [], $options = [])
    {
        $options['id'] = 'js-bootstrap-dropdown-select' . \yii::$app->security->generateRandomString();
        return \yii::$app->view->renderFile(__DIR__ . '/views/active-bootstrap-dropdown-select.php', [
            'model'     => $model,
            'attr'      => $attr,
            'items'     => $items,
            'options'   => $options,
        ]);
    }

}
