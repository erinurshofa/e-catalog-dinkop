<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use common\models\User;
use common\models\UmkmProfile;
use common\models\Products;
use common\models\ProductImage;
use common\models\Categories;

class DummyDataController extends Controller
{
    public function actionGenerate()
    {
        $user = User::findOne(['username' => 'umkm_demo']);
        if (!$user) {
            $this->stdout("User 'umkm_demo' not found.\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $profile = UmkmProfile::findOne(['user_id' => $user->id]);
        if (!$profile) {
            $this->stdout("UmkmProfile for 'umkm_demo' not found.\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $dummyProducts = [
            ['Keripik Pisang Rasa Coklat', 'Makanan & Minuman', 'Cemilan manis dan renyah terbuat dari pisang pilihan dengan taburan coklat lezat.', 15000, 50, 'Bungkus', 'keripik-pisang-rasa-coklat.webp'],
            ['Sambal Roa Manado Asli', 'Makanan & Minuman', 'Sambal khas Manado dengan ikan roa yang pedas dan gurih.', 35000, 20, 'Botol', 'sambal-roa-manado.webp'],
            ['Kopi Susu Gula Aren Literan', 'Makanan & Minuman', 'Kopi susu dengan campuran gula aren asli yang pas untuk dinikmati bersama.', 65000, 15, 'Botol 1L', 'kopi-susu-gula-aren.webp'],
            ['Batik Tulis Khas Daerah', 'Pakaian & Aksesoris', 'Kain batik tulis motif khas daerah, bahan katun premium.', 350000, 5, 'Pcs', 'batik-tulis-khas.webp'],
            ['Tas Anyaman Rotan Cantik', 'Pakaian & Aksesoris', 'Tas wanita berbahan dasar rotan asli, cocok untuk bergaya.', 120000, 10, 'Pcs', 'tas-anyaman-rotan.webp'],
            ['Sepatu Kulit Pria Casual', 'Pakaian & Aksesoris', 'Sepatu kulit sapi asli untuk pria, nyaman dipakai sehari-hari.', 450000, 8, 'Pasang', 'sepatu-kulit-pria.webp'],
            ['Madu Hutan Liar Murni', 'Kesehatan & Perawatan', 'Madu asli dari hutan liar yang baik untuk kesehatan tubuh.', 110000, 25, 'Botol', 'madu-hutan-liar.webp'],
            ['Kue Kering Nastar Keju', 'Makanan & Minuman', 'Kue nastar isi selai nanas dengan taburan keju melimpah.', 85000, 30, 'Toples', 'kue-nastar-keju.webp'],
            ['Sabun Mandi Organik', 'Kesehatan & Perawatan', 'Sabun mandi berbahan organik tanpa bahan kimia berbahaya, aman untuk kulit sensitif.', 30000, 40, 'Pcs', 'sabun-mandi-organik.webp'],
            ['Abon Sapi Super Gurih', 'Makanan & Minuman', 'Abon sapi murni yang diolah dengan bumbu spesial, sangat cocok disajikan dengan nasi hangat.', 75000, 18, 'Bungkus', 'abon-sapi-super.webp'],
            ['Teh Herbal Rosella', 'Kesehatan & Perawatan', 'Teh seduh bunga rosella kaya akan antioksidan dan vitamin C tinggi.', 25000, 22, 'Bungkus', 'teh-herbal-rosella.webp'],
            ['Kerajinan Tangan Lampu Hias', 'Kerajinan Tangan', 'Lampu hias unik terbuat dari bambu dan kertas daur ulang.', 140000, 12, 'Pcs', 'lampu-hias-bambu.webp'],
        ];

        Products::deleteAll(['umkm_profile_id' => $profile->id]);
        
        // Ensure standard categories exist
        $existingCategories = Categories::find()->indexBy('name')->all();
        
        $count = 0;
        // Loop multiple times to generate more products for pagination testing
        for ($i = 0; $i < 4; $i++) {
            foreach ($dummyProducts as $index => $item) {
                
                $categoryName = $item[1];
                if (!isset($existingCategories[$categoryName])) {
                    $cat = new Categories();
                    $cat->name = $categoryName;
                    $cat->slug = strtolower(str_replace([' & ', ' ', '&'], ['-', '-', '-'], $categoryName));
                    $cat->type = 'product';
                    $cat->save(false);
                    $existingCategories[$categoryName] = $cat;
                }
                
                $categoryModel = $existingCategories[$categoryName];

                $product = new Products();
                $product->umkm_profile_id = $profile->id;
                $product->category_id = $categoryModel->id;
                $product->name = $item[0] . ($i > 0 ? " (Varian " . ($i+1) . ")" : "");
                $product->slug = 'product-' . time() . '-' . rand(100,999) . '-' . strtolower(str_replace(' ', '-', $item[0]));
                $product->description = $item[2];
                $product->price = $item[3] + ($i * 5000);
                $product->stock = $item[4];
                $product->unit = $item[5];
                $product->is_featured = rand(0, 1) > (($i == 0) ? 0.5 : 0.8) ? 1 : 0;
                $product->status = 1;
                $product->created_at = time() - rand(0, 864000); 
                $product->updated_at = time();
                
                if ($product->save(false)) {
                    $count++;
                    
                    // Add Product Image (primary image)
                    $image = new ProductImage();
                    $image->product_id = $product->id;
                    $image->image_path = 'https://picsum.photos/seed/img' . $count . time() . '/600/400';
                    $image->is_primary = 1;
                    $image->created_at = time();
                    $image->save(false);

                    // Add secondary image
                    $image2 = new ProductImage();
                    $image2->product_id = $product->id;
                    $image2->image_path = 'https://picsum.photos/seed/img2' . $count . time() . '/600/400';
                    $image2->is_primary = 0;
                    $image2->created_at = time();
                    $image2->save(false);
                } else {
                    $this->stdout("Failed to save product: " . json_encode($product->errors) . "\n");
                }
            }
        }

        $this->stdout("Successfully generated $count dummy products for 'umkm_demo'.\n");
        return ExitCode::OK;
    }
}
