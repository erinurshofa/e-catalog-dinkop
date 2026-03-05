<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_images}}`.
 */
class m260305_044912_create_product_images_table extends Migration
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

        $this->createTable('{{%product_images}}', [
            'id' => $this->bigPrimaryKey(),
            'product_id' => $this->bigInteger()->notNull(),
            'image_path' => $this->string(255)->notNull(),
            'image_path_thumb' => $this->string(255),
            'is_primary' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-product_images-product_id', '{{%product_images}}', 'product_id');
        $this->addForeignKey('fk-product_images-product_id', '{{%product_images}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_images-product_id', '{{%product_images}}');
        $this->dropTable('{{%product_images}}');
    }
}
