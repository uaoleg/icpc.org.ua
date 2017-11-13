<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

$this->registerJsFile('@web/lib/ckeditor-4.2/ckeditor.js', ['position' => \yii\web\View::POS_HEAD]);

$this->registerCssFile('@web/lib/select2/select2.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('@web/lib/select2/select2-bootstrap.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/lib/select2/select2.js', ['position' => \yii\web\View::POS_HEAD]);

?>

<?php if ($question->isNewRecord): ?>
    <h2><?=\yii::t('app', 'Create a new Question')?></h2>
<?php else: ?>
    <h2><?=\yii::t('app', 'Edit Question')?></h2>
<?php endif; ?>

<div class="form-horizontal">
    <input type="hidden" name="id" value="<?=$question->id?>" />
    <div class="form-group">
        <input type="text" class="form-control" name="title"
               value="<?=Html::encode($question->title)?>"
               placeholder="<?=\yii::t('app', 'Title')?>">
    </div>
    <div class="form-group">
        <textarea class="form-control"
                  name="content"
                  id="question-content"
                  style="height: 500px;"><?=Html::encode($question->content)?></textarea>
    </div>
    <div class="form-group">
        <select name="tagList" multiple>
            <?php foreach($tags as $tag): ?>
                <option value="<?=$tag->id?>"><?=$tag->name?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary btn-lg question-save">
            <?=\yii::t('app', 'Save question')?>
        </button>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        new appQaManage();
    });
</script>
