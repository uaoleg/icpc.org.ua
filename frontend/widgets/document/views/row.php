<?php

/* @var $this                   \yii\web\View */
/* @var $document               \common\models\Document */
/* @var $afterDeleteRedirect    string */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

<table class="document"
       style="margin-bottom: 20px;"
       data-id="<?=$document->id?>"
       data-after-delete-redirect="<?=$afterDeleteRedirect?>">
    <tr>
        <td>
            <?=\frontend\widgets\document\Icon::widget(array('document' => $document))?>
        </td>
        <td>
            <a href="<?=Url::toRoute(['/docs/download', 'id' => $document->id])?>" class="document-title">
                <?=Html::encode($document->title)?></a>
            <span class="document-size"><?=\frontend\widgets\document\Size::widget(array('document' => $document))?></span>
            <?php if (\yii::$app->user->can(\common\components\Rbac::OP_DOCUMENT_UPDATE, array(
                'document' => $document,
            ))): ?>
            <a href="<?=Url::toRoute(['/staff/docs/edit', 'id' => $document->id])?>" class="btn btn-info btn-xs"><?=\yii::t('app', 'Edit')?></a>
            <?php endif; ?>
            <?php if (\yii::$app->user->can(\common\components\Rbac::OP_DOCUMENT_DELETE, array(
                'document' => $document,
            ))): ?>
                <button type="button" class="btn btn-danger btn-xs document-delete"
                        data-bootbox-confirm="<?=\yii::t('app', 'Delete {file} ?', array(
                            'file' => '<i>' . Html::encode($document->title) . '</i>',
                        ))?>">
                    <?=\yii::t('app', 'Delete')?>
                </button>
            <?php endif; ?>
            <p class="document-desc"><?=$document->desc?></p>
        </td>
    </tr>
</table>