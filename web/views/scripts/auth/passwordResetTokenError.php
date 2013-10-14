<div class="col-lg-offset-4 col-lg-4">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title"><?=\yii::t('app', 'Password reset')?></h3>
        </div>
        <div class="panel-body">
            <p><strong><?=\yii::t('app', 'Your token is invalid or expired.')?></strong></p>
            <a href="<?=$this->createUrl('passwordReset')?>"><?=\yii::t('app', 'Resend token')?></a>
            <br />
            <a href="/"><?=\yii::t('app', 'Return back to the main page')?></a>
        </div>
    </div>
</div>