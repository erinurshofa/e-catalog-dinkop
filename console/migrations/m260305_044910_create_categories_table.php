<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m260305_044910_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->null(),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->notNull()->unique(),
            'type' => $this->string(20)->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-categories-parent_id', '{{%categories}}', 'parent_id');
        $this->addForeignKey('fk-categories-parent_id', '{{%categories}}', 'parent_id', '{{%categories}}', 'id', 'SET NULL', 'CASCADE');
        $this->createIndex('idx-categories-name', '{{%categories}}', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-categories-parent_id', '{{%categories}}');
        $this->dropTable('{{%categories}}');
    }
}
