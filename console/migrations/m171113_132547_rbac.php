<?php

class m171113_132547_rbac extends \yii\db\Migration
{

    public function up()
    {
        \yii::$app->db->createCommand()->insert('auth_rule', [
            'name'          => 'QaQuestionUpdateRule',
            'data'          => serialize(new \common\rbac\QaQuestionUpdateRule),
            'created_at'    => time(),
            'updated_at'    => null,
        ])->execute();
        \yii::$app->db->createCommand()->update('auth_item', [
            'rule_name' => 'QaQuestionUpdateRule'
        ], [
            'name' => 'qaQuestionUpdate',
        ])->execute();
    }

    public function down()
    {
        echo "m171113_132547_rbac cannot be reverted.\n";

        return false;
    }

}
