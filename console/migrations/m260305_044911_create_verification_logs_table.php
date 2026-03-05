<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%verification_logs}}`.
 */
class m260305_044911_create_verification_logs_table extends Migration
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

        $this->createTable('{{%verification_logs}}', [
            'id' => $this->bigPrimaryKey(),
            'entity_type' => $this->string(50)->notNull(),
            'entity_id' => $this->bigInteger()->notNull(),
            'admin_user_id' => $this->integer()->notNull(),
            'action' => $this->string(20)->notNull(),
            'notes' => $this->text(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-verification_logs-admin_user_id', '{{%verification_logs}}', 'admin_user_id');
        $this->addForeignKey('fk-verification_logs-admin_user_id', '{{%verification_logs}}', 'admin_user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        
        $this->createIndex('idx-verification_logs-entity_type_id', '{{%verification_logs}}', ['entity_type', 'entity_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-verification_logs-admin_user_id', '{{%verification_logs}}');
        $this->dropTable('{{%verification_logs}}');
    }
}
