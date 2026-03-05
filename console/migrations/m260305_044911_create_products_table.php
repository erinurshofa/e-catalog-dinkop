<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m260305_044911_create_products_table extends Migration
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

        $this->createTable('{{%products}}', [
            'id' => $this->bigPrimaryKey(),
            'umkm_profile_id' => $this->bigInteger()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string(200)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'description' => $this->text(),
            'price' => $this->decimal(12, 2)->notNull(),
            'is_featured' => $this->tinyInteger()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'view_count' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-products-umkm_profile_id', '{{%products}}', 'umkm_profile_id');
        $this->addForeignKey('fk-products-umkm_profile_id', '{{%products}}', 'umkm_profile_id', '{{%umkm_profile}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx-products-category_id', '{{%products}}', 'category_id');
        $this->addForeignKey('fk-products-category_id', '{{%products}}', 'category_id', '{{%categories}}', 'id', 'RESTRICT', 'CASCADE');

        $this->execute('ALTER TABLE {{%products}} ADD FULLTEXT INDEX idx_ft_product_name (name)');
        
        $this->createIndex('idx-products-price', '{{%products}}', 'price');
        $this->createIndex('idx-products-is_featured', '{{%products}}', 'is_featured');
        $this->createIndex('idx-products-status', '{{%products}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-products-category_id', '{{%products}}');
        $this->dropForeignKey('fk-products-umkm_profile_id', '{{%products}}');
        $this->dropTable('{{%products}}');
    }
}
