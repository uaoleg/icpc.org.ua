<div class="col-lg-4 col-lg-offset-4">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?=\yii::t('app', 'Thank you!')?>
        </div>
        <div class="panel-body">
            <?=\yii::t('app', 'Now you can authorize on {link}login page</a>', array(
                '{link}' => '<a href="' . $this->createUrl('auth/login') . '">'
            ))?>
        </div>
    </div>
</div>