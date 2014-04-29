<?php if (!$success): ?>
    <div class="col-lg-4 col-lg-offset-4">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <?=\yii::t('app', 'Something went wrong!')?>
            </div>
            <div class="panel-body">
                <?=\yii::t('app', 'Please, check the link provided in the confirmation email')?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="col-lg-4 col-lg-offset-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <?=\yii::t('app', 'Email verified successfully!')?>
            </div>
            <div class="panel-body">
                <?=\yii::t('app', 'Now you can authorize on {a}login page{/a}', array(
                    '{a}'   => '<a href="' . $this->createUrl('auth/login') . '">',
                    '{/a}'  => '</a>',
                ))?>
            </div>
        </div>
    </div>
<?php endif; ?>