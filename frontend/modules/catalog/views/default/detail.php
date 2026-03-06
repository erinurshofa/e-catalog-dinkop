<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $product common\models\Products */
/* @var $relatedProducts common\models\Products[] */

$this->title = $product->name . ' - Katalog UMKM';
$this->params['breadcrumbs'][] = ['label' => 'Katalog Produk', 'url' => ['index']];
$this->params['breadcrumbs'][] = $product->name;

// Get Main Image
$primaryImage = 'https://via.placeholder.com/800x800?text=No+Image';
$galleryImages = [];

if (!empty($product->productImages)) {
    foreach ($product->productImages as $img) {
        if ($img->is_primary) {
            $primaryImage = $img->image_path;
        } else {
            $galleryImages[] = $img->image_path;
        }
    }
    // If no primary flag was set but images exist
    if ($primaryImage === 'https://via.placeholder.com/800x800?text=No+Image' && count($product->productImages) > 0) {
        $primaryImage = $product->productImages[0]->image_path;
        array_shift($galleryImages); // Remove it from gallery array if it was there
    }
}

// Format WhatsApp Message
$waMessage = rawurlencode("Halo kak, saya tertarik dengan produk *" . $product->name . "* yang ada di E-Catalog UMKM.\n\nLink Produk: " . Url::to(['/catalog/default/detail', 'slug' => $product->slug], true) . "\n\nApakah stoknya masih tersedia?");
$waNumber = $product->umkmProfile ? $product->umkmProfile->no_whatsapp : '#';
if (substr($waNumber, 0, 1) == '0') {
    $waNumber = '62' . substr($waNumber, 1);
}

// Custom CSS for premium detail page
$this->registerCss("
    body {
        background-color: #fcfcfc;
    }
    .detail-container {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        padding: 3rem;
        margin-bottom: 4rem;
    }
    
    /* Image Gallery */
    .product-gallery {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        position: sticky;
        top: 2rem;
    }
    .main-image-wrapper {
        border-radius: 1rem;
        overflow: hidden;
        background: #f8f9fa;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .main-image-wrapper:hover .main-image {
        transform: scale(1.05);
    }
    .thumbnail-list {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        scrollbar-width: none; /* Firefox */
    }
    .thumbnail-list::-webkit-scrollbar {
        display: none; /* Chrome, Safari */
    }
    .thumb-btn {
        width: 80px;
        height: 80px;
        border-radius: 0.5rem;
        border: 2px solid transparent;
        overflow: hidden;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.2s;
        padding: 0;
        background: #fff;
    }
    .thumb-btn.active {
        border-color: #1a1a1a;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .thumb-btn img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Product Info Section */
    .product-details {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .badge-category {
        background: #f0f4f8;
        color: #4a90e2;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        margin-bottom: 0.5rem;
    }
    .detail-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1a1a1a;
        line-height: 1.2;
        margin: 0;
        letter-spacing: -0.5px;
    }
    .detail-price {
        font-size: 2.5rem;
        font-weight: 800;
        color: #4a90e2;
        margin: 0;
    }
    .product-meta {
        display: flex;
        gap: 1.5rem;
        color: #666;
        font-size: 0.95rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
    }
    .meta-item i {
        color: #888;
        margin-right: 0.5rem;
    }
    .detail-desc {
        color: #444;
        font-size: 1.1rem;
        line-height: 1.8;
        white-space: pre-line;
    }
    .action-container {
        background: #f8f9fa;
        border: 1px solid #eee;
        border-right: 4px solid #25D366;
        padding: 1.5rem;
        border-radius: 1rem;
        margin-top: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .action-label {
        font-weight: 700;
        color: #1a1a1a;
        font-size: 1.1rem;
        margin-bottom: 0.2rem;
    }
    .action-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: #25D366;
        letter-spacing: 1px;
    }
    .action-button {
        background: #25D366;
        color: #fff;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.2);
        border: none;
        align-self: flex-start;
        margin-top: 0.5rem;
    }
    .action-button:hover {
        background: #1ead53;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.3);
    }

    /* UMKM Info Card */
    .umkm-profile-card {
        background: #fafafa;
        border: 1px solid #eee;
        border-radius: 1rem;
        padding: 2rem;
        margin-top: 2rem;
    }
    .umkm-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 1.5rem;
    }
    .umkm-avatar {
        width: 60px;
        height: 60px;
        background: #1a1a1a;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
    }
    .umkm-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }
    .umkm-owner {
        color: #666;
        font-size: 0.9rem;
        margin: 0;
        margin-top: 0.2rem;
    }
    .umkm-verified {
        color: #25D366;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.3rem;
    }
    .umkm-info-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .umkm-info-item {
        display: flex;
        gap: 1rem;
        color: #555;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    .umkm-info-item i {
        color: #888;
        font-size: 1.1rem;
        margin-top: 0.2rem;
        width: 20px;
        text-align: center;
    }
    .umkm-map-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #e9ecef;
        color: #1a1a1a;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        margin-top: 0.5rem;
    }
    .umkm-map-btn:hover {
        background: #dde0e3;
        color: #1a1a1a;
    }

    /* Related Products */
    .related-section {
        margin-top: 5rem;
        margin-bottom: 3rem;
    }
    .related-title {
        font-weight: 800;
        font-size: 1.8rem;
        margin-bottom: 2rem;
        color: #1a1a1a;
        position: relative;
        padding-bottom: 1rem;
    }
    .related-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: #1a1a1a;
        border-radius: 2px;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }
    .product-card {
        background: #fff;
        border-radius: 1rem;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border-color: #e0e0e0;
    }
    .product-img-wrapper {
        position: relative;
        padding-top: 100%; /* 1:1 Aspect Ratio */
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .product-card:hover .product-img {
        transform: scale(1.05);
    }
    .product-info {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .product-category {
        color: #888;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
        font-weight: 600;
    }
    .product-title {
        font-weight: 700;
        font-size: 1.05rem;
        line-height: 1.4;
        margin-bottom: 0.8rem;
        color: #1a1a1a;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }
    .product-price {
        font-weight: 800;
        font-size: 1.2rem;
        color: #4a90e2;
    }
    
    @media (max-width: 992px) {
        .detail-container {
            padding: 2rem;
        }
        .detail-title {
            font-size: 1.8rem;
        }
        .detail-price {
            font-size: 2rem;
        }
    }
");

// Register AlpineJS for Image Gallery interaction if not already registered globally
$this->registerJsFile('https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js', ['position' => \yii\web\View::POS_HEAD, 'defer' => true]);
?>

<div class="container py-4">
    <!-- Breadcrumbs override for better styling -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0 m-0 font-weight-500">
            <li class="breadcrumb-item"><a href="<?= Url::to(['/catalog/default/index']) ?>" class="text-decoration-none text-muted">Katalog</a></li>
            <?php if ($product->category): ?>
                <li class="breadcrumb-item"><a href="<?= Url::to(['/catalog/default/index', 'category_id' => $product->category->id]) ?>" class="text-decoration-none text-muted"><?= Html::encode($product->category->name) ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active text-dark font-weight-bold" aria-current="page"><?= Html::encode($product->name) ?></li>
        </ol>
    </nav>

    <div class="detail-container">
        <div class="row g-5">
            <!-- Left: Image Gallery (Alpine.js handled) -->
            <div class="col-lg-5" x-data="{ activeImage: '<?= Html::encode($primaryImage) ?>' }">
                <div class="product-gallery">
                    <div class="main-image-wrapper">
                        <img :src="activeImage" alt="<?= Html::encode($product->name) ?>" class="main-image">
                    </div>
                    
                    <?php if (!empty($galleryImages)): ?>
                        <div class="thumbnail-list mt-3">
                            <button class="thumb-btn" :class="{ 'active': activeImage === '<?= Html::encode($primaryImage) ?>' }" @click="activeImage = '<?= Html::encode($primaryImage) ?>'">
                                <img src="<?= Html::encode($primaryImage) ?>" alt="Thumbnail">
                            </button>
                            <?php foreach ($galleryImages as $imgUrl): ?>
                                <button class="thumb-btn" :class="{ 'active': activeImage === '<?= Html::encode($imgUrl) ?>' }" @click="activeImage = '<?= Html::encode($imgUrl) ?>'">
                                    <img src="<?= Html::encode($imgUrl) ?>" alt="Thumbnail">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right: Product Information -->
            <div class="col-lg-7">
                <div class="product-details">
                    <div>
                        <span class="badge-category"><?= $product->category ? Html::encode($product->category->name) : 'Kategori Umum' ?></span>
                        <h1 class="detail-title"><?= Html::encode($product->name) ?></h1>
                    </div>
                    
                    <div class="detail-price">
                        Rp <?= number_format($product->price, 0, ',', '.') ?>
                    </div>

                    <div class="product-meta">
                        <div class="meta-item">
                            <i class="fas fa-box"></i> Stok: <strong class="text-dark"><?= $product->stock ?> <?= Html::encode($product->unit) ?></strong>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-eye"></i> Dilihat: <strong class="text-dark"><?= $product->view_count ?> kali</strong>
                        </div>
                        <?php if ($product->is_featured): ?>
                            <div class="meta-item text-warning fw-bold">
                                <i class="fas fa-star"></i> Produk Unggulan
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="detail-desc">
                        <?= nl2br(Html::encode($product->description)) ?>
                    </div>

                    <div class="action-container">
                        <div class="action-label">Hubungi Penjual (WhatsApp)</div>
                        <div class="action-number">
                            <i class="fab fa-whatsapp"></i> <?= Html::encode($waNumber) ?>
                        </div>
                        <p class="text-muted mb-0" style="font-size:0.9rem;">Silakan simpan nomor ini atau klik tombol di bawah untuk membuka chat.</p>
                        <a href="https://api.whatsapp.com/send?phone=<?= $waNumber ?>&text=<?= $waMessage ?>" target="_blank" class="action-button">
                            Chat Sekarang <i class="fas fa-external-link-alt ms-1" style="font-size:0.8rem;"></i>
                        </a>
                    </div>

                    <!-- UMKM Info Card -->
                    <?php if ($product->umkmProfile): ?>
                        <div class="umkm-profile-card">
                            <div class="umkm-header">
                                <div class="umkm-avatar">
                                    <?= strtoupper(substr($product->umkmProfile->nama_usaha, 0, 1)) ?>
                                </div>
                                <div>
                                    <h3 class="umkm-name"><?= Html::encode($product->umkmProfile->nama_usaha) ?></h3>
                                    <p class="umkm-owner">Oleh: <?= Html::encode($product->umkmProfile->nama_pemilik) ?></p>
                                    <?php if ($product->umkmProfile->status_verifikasi == 1): ?>
                                        <div class="umkm-verified"><i class="fas fa-check-circle"></i> UMKM Terverifikasi Dinas</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <ul class="umkm-info-list">
                                <li class="umkm-info-item">
                                    <i class="fas fa-id-card"></i>
                                    <div>
                                        <strong>Nomor Induk Berusaha (NIB)</strong><br>
                                        <?= Html::encode($product->umkmProfile->nib ?? 'Belum tersedia') ?>
                                    </div>
                                </li>
                                <li class="umkm-info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <strong>Alamat Usaha</strong><br>
                                        <?= Html::encode($product->umkmProfile->alamat_usaha) ?>
                                        
                                        <?php if (!empty($product->umkmProfile->link_gmaps)): ?>
                                            <div class="mt-2">
                                                <a href="<?= Html::encode($product->umkmProfile->link_gmaps) ?>" target="_blank" class="umkm-map-btn">
                                                    <i class="fas fa-map"></i> Buka di Google Maps
                                                </a>
                                            </div>
                                        <?php elseif (!empty($product->umkmProfile->latitude) && !empty($product->umkmProfile->longitude)): ?>
                                            <div class="mt-2">
                                                <a href="https://www.google.com/maps/search/?api=1&query=<?= $product->umkmProfile->latitude ?>,<?= $product->umkmProfile->longitude ?>" target="_blank" class="umkm-map-btn">
                                                    <i class="fas fa-map"></i> Buka di Google Maps
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="related-section">
            <h2 class="related-title">Produk Lainnya di <?= $product->category ? Html::encode($product->category->name) : 'Kategori Ini' ?></h2>
            <div class="product-grid">
                <?php foreach ($relatedProducts as $relProduct): ?>
                    <div class="product-card">
                        <?php 
                            $relImage = null;
                            if (!empty($relProduct->productImages)) {
                                foreach ($relProduct->productImages as $img) {
                                    if ($img->is_primary) {
                                        $relImage = $img->image_path;
                                        break;
                                    }
                                }
                                if (!$relImage) $relImage = $relProduct->productImages[0]->image_path;
                            } else {
                                $relImage = 'https://via.placeholder.com/600x600?text=No+Image';
                            }
                        ?>
                        <div class="product-img-wrapper">
                            <img src="<?= Html::encode($relImage) ?>" alt="<?= Html::encode($relProduct->name) ?>" class="product-img" loading="lazy">
                        </div>
                        <div class="product-info">
                            <div class="product-category"><?= $relProduct->category ? Html::encode($relProduct->category->name) : 'Kategori Umum' ?></div>
                            <h3 class="product-title">
                                <a href="<?= Url::to(['/catalog/default/detail', 'slug' => $relProduct->slug]) ?>" class="text-decoration-none text-dark stretched-link">
                                    <?= Html::encode($relProduct->name) ?>
                                </a>
                            </h3>
                            <div class="product-footer">
                                <div class="product-price">Rp <?= number_format($relProduct->price, 0, ',', '.') ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
