<div class="alert alert-warning">
    <h4><?=\yii::t('app', 'Requested news has no translation in {lang}', array(
        '{lang}' => isset(\yii::app()->params['languages'][$lang]) ? \yii::app()->params['languages'][$lang] : $lang,
    ))?></h4>
    <?=\yii::t('app', 'Find it out in other languages')?>:
    <ul>
    <?php foreach ($newsList as $news): ?>
        <li>
            <?=isset(\yii::app()->params['languages'][$news->lang]) ? \yii::app()->params['languages'][$news->lang] : $news->lang?>
            <br />
            <a href="<?=$this->createUrl('view', array(
                'id'    => $news->commonId,
                'lang'  => $news->lang,
            ))?>"><?=$news->title?></a>
        </li>
    <?php endforeach; ?>
    </ul>
</div>