<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%umkm_profile}}`.
 */
class m260305_044910_create_umkm_profile_table extends Migration
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

        $this->createTable('{{%umkm_profile}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->integer()->notNull(),
            'nama_pemilik' => $this->string(150)->notNull(),
            'nik' => $this->string(16)->notNull()->unique(),
            'alamat_pemilik' => $this->text()->notNull(),
            'nama_usaha' => $this->string(150)->notNull(),
            'alamat_usaha' => $this->text()->notNull(),
            'kecamatan_id' => $this->integer(),
            'kelurahan_id' => $this->integer(),
            'nib' => $this->string(50)->unique(),
            'no_whatsapp' => $this->string(20)->notNull(),
            'latitude' => $this->decimal(10, 8),
            'longitude' => $this->decimal(10, 8),
            'modal_awal' => $this->decimal(15, 2),
            'aset_usaha' => $this->decimal(15, 2),
            'omzet_usaha' => $this->decimal(15, 2),
            'deskripsi_usaha' => $this->text(),
            'kategori_usaha_id' => $this->integer(),
            'status_verifikasi' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-umkm_profile-user_id', '{{%umkm_profile}}', 'user_id');
        $this->addForeignKey('fk-umkm_profile-user_id', '{{%umkm_profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx-umkm_profile-nama_pemilik', '{{%umkm_profile}}', 'nama_pemilik');
        $this->execute('ALTER TABLE {{%umkm_profile}} ADD FULLTEXT INDEX idx_ft_nama_usaha (nama_usaha)');

        $this->createIndex('idx-umkm_profile-kategori_usaha_id', '{{%umkm_profile}}', 'kategori_usaha_id');
        $this->addForeignKey('fk-umkm_profile-kategori_usaha_id', '{{%umkm_profile}}', 'kategori_usaha_id', '{{%categories}}', 'id', 'SET NULL', 'CASCADE');
        $this->createIndex('idx-umkm_profile-status_verifikasi', '{{%umkm_profile}}', 'status_verifikasi');
        $this->createIndex('idx-umkm_profile-omzet_usaha', '{{%umkm_profile}}', 'omzet_usaha');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-umkm_profile-kategori_usaha_id', '{{%umkm_profile}}');
        $this->dropForeignKey('fk-umkm_profile-user_id', '{{%umkm_profile}}');
        $this->dropTable('{{%umkm_profile}}');
    }
}
