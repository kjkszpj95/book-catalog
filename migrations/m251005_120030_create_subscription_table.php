<?php

use yii\db\Migration;

class m251005_120030_create_subscription_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(20)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Уникальность: один номер — одна подписка на автора
        $this->createIndex('idx_subscription_unique', '{{%subscription}}', ['author_id', 'phone'], true);

        $this->addForeignKey(
            'fk_subscription_author',
            '{{%subscription}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_subscription_author', '{{%subscription}}');
        $this->dropTable('{{%subscription}}');
    }
}