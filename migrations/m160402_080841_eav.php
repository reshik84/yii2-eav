<?php

use yii\db\Migration;

class m160402_080841_eav extends Migration
{
    public function up()
    {
        $this->createTable('{{%eav_entity}}', [
            'id' => $this->primaryKey(),
            'class' => $this->string()
        ]);
        
        $this->createTable('{{%eav_attributes}}', [
            'id' => $this->primaryKey(),
            'class_id' => $this->integer(),
            'attribute' => $this->string()
        ]);
        
        $this->createTable('{{%eav_values}}', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'value' => $this->text()
        ]);
        
        $this->addForeignKey('attr_val', '{{%eav_values}}', ['attribute_id'], '{{%eav_attributes}}', ['id']);
        $this->addForeignKey('ent_attr', '{{%eav_attributes}}', ['class_id'], '{{%eav_entity}}', ['id']);
        
    }

    public function down()
    {
        $this->dropTable('{{%eav_values}}');
        $this->dropTable('{{%eav_attributes}}');
        $this->dropTable('{{%eav_entity}}');
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
