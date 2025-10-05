<?php

use yii\db\Migration;

class m251005_120010_create_book_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'year' => $this->integer()->notNull(),
            'description' => $this->text(),
            'isbn' => $this->string(32)->unique(),
            'cover_url' => $this->string(512),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}