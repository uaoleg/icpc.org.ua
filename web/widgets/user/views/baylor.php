<script type="text/javascript">
    $(document).ready(function() {
        new appUserBaylor();
    });
</script>

<button type="button"
        class="btn btn-lg btn-warning"
        title="<?=\yii::t('app', 'Import from icpc.baylor.edu')?>"
        rel="tooltip"
        data-toggle="modal"
        data-target="#baylor-modal">
    <span class="glyphicon glyphicon-cloud-download"></span>
</button>

<div class="modal fade" id="baylor-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?=\yii::t('app', 'Import from icpc.baylor.edu')?></h4>
            </div>
            <div class="modal-body">
                <p>
                    <?= \yii::t('app', 'We promise we will not save any of the data!') ?>
                </p>
                <div class="form-group">
                    <label for="baylor-modal__email">Email</label>
                    <input type="email" class="form-control" id="baylor-modal__email"
                           value="<?=(\yii::app()->user->getState('baylor_email', false))?:''?>" />
                </div>
                <div class="form-group">
                    <label for="baylor-modal__password">Пароль</label>
                    <input type="password" class="form-control" id="baylor-modal__password" />
                </div>
                <div class="progress progress-striped active hide">
                    <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                </div>
                <div class="alert alert-danger hide"><?= \yii::t('app', 'Email or password is invalid') ?></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-primary btn-baylor-import"><?=\yii::t('app', 'Import')?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->