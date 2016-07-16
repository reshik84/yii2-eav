<?php

use yii\db\Migration;

class m160331_181629_guest extends Migration
{
    public function up()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255),
            'email' => $this->string(255),
            'text' => $this->text(),
            'created_at' => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m160331_181629_guest cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
