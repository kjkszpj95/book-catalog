<?php

use yii\db\Migration;

class m251005_120000_create_author_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(255)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%author}}');
    }
}