<?php

use \common\models\User\EmailConfirmation;

class m171108_084903_user_email_confirmation extends \yii\db\Migration
{

    public function up()
    {
        $this->execute("
            ALTER TABLE `user_email_confirmation`
                ADD COLUMN `hash` VARCHAR(50) NOT NULL AFTER `userId`;
        ");

        $emails = EmailConfirmation::find()->all();
        foreach ($emails as $email) {
            $email->save(false);
        }

        $this->execute("
            ALTER TABLE `user_email_confirmation`
                ADD UNIQUE INDEX `hash` (`hash`);
        ");
    }

    public function down()
    {
        echo "m171108_084903_user_email_confirmation cannot be reverted.\n";

        return false;
    }

}
