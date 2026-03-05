<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%umkm_documents}}`.
 */
class m260305_044911_create_umkm_documents_table extends Migration
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

        $this->createTable('{{%umkm_documents}}', [
            'id' => $this->bigPrimaryKey(),
            'umkm_profile_id' => $this->bigInteger()->notNull(),
            'jenis_dokumen' => $this->string(50)->notNull(),
            'nomor_dokumen' => $this->string(100),
            'file_path' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-umkm_documents-umkm_profile_id', '{{%umkm_documents}}', 'umkm_profile_id');
        $this->addForeignKey('fk-umkm_documents-umkm_profile_id', '{{%umkm_documents}}', 'umkm_profile_id', '{{%umkm_profile}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-umkm_documents-umkm_profile_id', '{{%umkm_documents}}');
        $this->dropTable('{{%umkm_documents}}');
    }
}
