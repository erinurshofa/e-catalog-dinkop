<?php

use yii\db\Migration;

class m260306_024255_seed_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $categories = [
            // Kategori Usaha (Sektor Utama) - type = 'usaha'
            ['name' => 'Kuliner', 'slug' => 'kuliner', 'type' => 'usaha'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'type' => 'usaha'],
            ['name' => 'Kriya & Kerajinan', 'slug' => 'kriya-kerajinan', 'type' => 'usaha'],
            ['name' => 'Jasa', 'slug' => 'jasa', 'type' => 'usaha'],
            ['name' => 'Agrobisnis', 'slug' => 'agrobisnis', 'type' => 'usaha'],
            ['name' => 'Teknologi & Digital', 'slug' => 'teknologi-digital', 'type' => 'usaha'],
            ['name' => 'Kesehatan & Kecantikan', 'slug' => 'kesehatan-kecantikan', 'type' => 'usaha'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'type' => 'usaha'],
            
            // Kategori Produk (Sub-sektor) - type = 'produk'
            // [Kuliner]
            ['name' => 'Makanan Kering / Ringan', 'slug' => 'makanan-kering-ringan', 'type' => 'produk'],
            ['name' => 'Makanan Basah', 'slug' => 'makanan-basah', 'type' => 'produk'],
            ['name' => 'Minuman', 'slug' => 'minuman', 'type' => 'produk'],
            ['name' => 'Bumbu & Rempah', 'slug' => 'bumbu-rempah', 'type' => 'produk'],
            
            // [Fashion]
            ['name' => 'Pakaian Pria', 'slug' => 'pakaian-pria', 'type' => 'produk'],
            ['name' => 'Pakaian Wanita', 'slug' => 'pakaian-wanita', 'type' => 'produk'],
            ['name' => 'Pakaian Anak', 'slug' => 'pakaian-anak', 'type' => 'produk'],
            ['name' => 'Aksesoris Fashion', 'slug' => 'aksesoris-fashion', 'type' => 'produk'],
            ['name' => 'Tas & Sepatu', 'slug' => 'tas-sepatu', 'type' => 'produk'],
            
            // [Kriya]
            ['name' => 'Kerajinan Kayu', 'slug' => 'kerajinan-kayu', 'type' => 'produk'],
            ['name' => 'Kerajinan Kulit', 'slug' => 'kerajinan-kulit', 'type' => 'produk'],
            ['name' => 'Kerajinan Tekstil', 'slug' => 'kerajinan-tekstil', 'type' => 'produk'],
            ['name' => 'Dekorasi Rumah', 'slug' => 'dekorasi-rumah', 'type' => 'produk'],
            
            // [Agrobisnis]
            ['name' => 'Hasil Pertanian', 'slug' => 'hasil-pertanian', 'type' => 'produk'],
            ['name' => 'Hasil Perkebunan', 'slug' => 'hasil-perkebunan', 'type' => 'produk'],
            ['name' => 'Peternakan', 'slug' => 'peternakan', 'type' => 'produk'],
            ['name' => 'Perikanan', 'slug' => 'perikanan', 'type' => 'produk'],
            
            // [Umum]
            ['name' => 'Produk Digital', 'slug' => 'produk-digital', 'type' => 'produk'],
            ['name' => 'Perawatan & Kosmetik', 'slug' => 'perawatan-kosmetik', 'type' => 'produk'],
            ['name' => 'Alat Kesehatan', 'slug' => 'alat-kesehatan', 'type' => 'produk'],
            ['name' => 'Peralatan Tulis & Kantor', 'slug' => 'peralatan-tulis-kantor', 'type' => 'produk'],
        ];

        foreach ($categories as $category) {
            $this->insert('{{%categories}}', [
                'name' => $category['name'],
                'slug' => $category['slug'],
                'type' => $category['type'],
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DELETE FROM {{%categories}}");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260306_024255_seed_categories_table cannot be reverted.\n";

        return false;
    }
    */
}
