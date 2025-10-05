<?php

use yii\db\Migration;

class m251005_120020_create_book_author_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk_book_author', '{{%book_author}}', ['book_id', 'author_id']);

        $this->addForeignKey(
            'fk_book_author_book',
            '{{%book_author}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_book_author_author',
            '{{%book_author}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_book_author_book', '{{%book_author}}');
        $this->dropForeignKey('fk_book_author_author', '{{%book_author}}');
        $this->dropTable('{{%book_author}}');
    }
}