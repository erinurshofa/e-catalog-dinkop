<?php

namespace common\services;

use Yii;
use common\models\Product;
use common\models\UmkmProfile;
use Exception;

/**
 * Service class for handling Product-related business logic.
 */
class ProductService
{
    /**
     * Tambah Produk Baru oleh UMKM
     * 
     * @param UmkmProfile $umkm
     * @param array $productData
     * @return Product|null
     * @throws Exception
     */
    public function createProduct(UmkmProfile $umkm, array $productData)
    {
        if ($umkm->status_verifikasi != 2) { // 2 = Approved
            throw new Exception("Hanya UMKM terverifikasi yang dapat menambahkan produk.");
        }

        $product = new Product();
        $product->umkm_profile_id = $umkm->id;
        $product->attributes = $productData;
        $product->status = 1; // Pending Review by default
        $product->created_at = time();
        $product->updated_at = time();

        if (!$product->save()) {
            throw new Exception('Failed to save Product: ' . json_encode($product->getErrors()));
        }

        return $product;
    }
}
