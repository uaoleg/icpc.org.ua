<?php

\yii::setAlias('@root', dirname(dirname(__DIR__)));
\yii::setAlias('@common', dirname(__DIR__));
\yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
\yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
\yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

\yii::$classMap[\yii\helpers\Html::class]           = '@common/helpers/Html.php';
\yii::$classMap[\yii\helpers\StringHelper::class]   = '@common/helpers/StringHelper.php';

\yii::$container->set(\yii\bootstrap\ActiveForm::class, [
    'fieldClass' => \common\widgets\ActiveField::class,
]);

\yii::$container->set(\yii\validators\NumberValidator::class, [
    'numberPattern' => '/^\s*[-+]?[0-9]*\.?([0-9]?)+([eE][-+]?[0-9]+)?\s*$/', // Support no zero after dot, e.g. "99."
]);
