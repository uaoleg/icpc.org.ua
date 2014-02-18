<script type="text/javascript">
    $(document).ready(function() {
        new appAuthSignedup();
    });
</script>

<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><?=\yii::t('app', 'E-mail confirmation')?></h3>
            </div>
            <div class="panel-body">
                <p><?=\yii::t('app', 'You have signed up successfully. We have sent an email confirmation link to your email.')?></p>
                <p>
                    <button class="btn btn-primary btn-resend-email" data-id="<?=$this->request->getParam('id')?>">
                        <?=\yii::t('app', 'Resend email')?>
                    </button>
                </p>
                <div class="alert alert-success fade in hide">
                    <strong><?=\yii::t('app', 'E-mail was resent successfully!')?></strong>
                </div>
            </div>
        </div>
    </div>
</div>