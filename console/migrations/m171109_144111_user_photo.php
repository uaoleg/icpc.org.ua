<?php

class m171109_144111_user_photo extends \yii\db\Migration
{

    public function up()
    {
        $this->execute("
            ALTER TABLE `user_photo`
                ADD COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT FIRST,
                DROP PRIMARY KEY,
                ADD PRIMARY KEY (`id`),
                ADD INDEX `userId` (`userId`);
        ");
    }

    public function down()
    {
        echo "m171109_144111_user_photo cannot be reverted.\n";

        return false;
    }

}
