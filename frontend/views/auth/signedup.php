<?php

/* @var $this \yii\web\View */

use \yii\helpers\Html;
use \yii\helpers\Url;

?>

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
                    <button class="btn btn-primary btn-resend-email" data-id="<?=$this->request->get('id')?>">
                        <?=\yii::t('app', 'Resend email')?>
                    </button>
                </p>
                <div class="alert alert-success fade in hide">
                    <strong><?=\yii::t('app', 'E-mail was resent successfully!')?></strong>
                </div>
                <div class="alert alert-warning fade in hide">
                    <strong><?=\yii::t('app', 'E-mail confirmation request can be sent no more than 1 time per day.')?></strong>
                </div>
            </div>
        </div>
    </div>
</div>