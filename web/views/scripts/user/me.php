<div class="col-lg-offset-4 col-lg-5">

    <table class="table table-bordered">
        <tr>
            <td>
                <?=\yii::t('app', 'Name')?>
            </td>
            <td>
                <?=$user->firstName?> <?=$user->lastName?>
            </td>
        </tr>
        <tr>
            <td>
                <?=\yii::t('app', 'Email')?>
            </td>
            <td>
                <?=$user->email?> <?=$user->lastName?>
            </td>
        </tr>
        <tr>
            <td>
                <?=\yii::t('app', 'User status')?>
            </td>
            <td>
                <?=$user->role?>
            </td>
        </tr>
    </table>

</div>
