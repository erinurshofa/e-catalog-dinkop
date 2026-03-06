<?php

/** @var yii\web\View $this */
/** @var common\models\Products[] $featuredProducts */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'SemarangpreneurUP - Katalog Produk UMKM Kota Semarang';
?>
<div class="site-index">

    <!-- HERO SECTION -->
    <div class="hero-section">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-7 position-relative z-1">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">Platform Resmi Pemkot Semarang</span>
                    <h1 class="hero-title">
                        Platform Resmi <br>
                        Produk <span class="text-warning">Usaha Mikro</span> Semarang
                    </h1>
                    <p class="hero-subtitle">
                        Segera hadir produk-produk unggulan karya asli UMKM Kota Semarang. Dukung produk lokal, bangkitkan ekonomi kita.
                    </p>
                    
                    <form action="<?= Url::to(['/catalog/default/index']) ?>" method="get" class="search-box-hero rounded-pill bg-white d-flex overflow-hidden mt-4">
                        <!-- Hidden input to preserve route without pretty URLs -->
                        <input type="hidden" name="r" value="catalog/default/index">
                        <input type="text" name="q" class="form-control border-0 shadow-none w-100" placeholder="Cari produk impian Anda di sini..." aria-label="Search">
                        <button type="submit" class="btn px-4 bg-warning">
                            <i class="fa-solid fa-search"></i> Cari
                        </button>
                    </form>
                </div>
                <div class="col-lg-5 d-none d-lg-block position-relative z-1 text-center">
                    <!-- Foto Walikota dan Wakil Walikota Semarang -->
                    <div style="background: rgba(255,193,7,0.1); border-radius: 20px; padding: 15px; margin: 0 auto; backdrop-filter: blur(5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        <img src="<?= Yii::getAlias('@web') ?>/images/walikotasemarang.jpeg" alt="Walikota dan Wakil Walikota Semarang" class="img-fluid rounded-3" style="object-fit: contain; width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CATEGORY SECTION -->
    <div class="container" style="margin-top: -30px; position: relative; z-index: 10;">
        <div class="row row-cols-2 row-cols-md-4 g-3">
            <div class="col">
                <a href="#" class="category-card py-4">
                    <i class="fa-solid fa-utensils category-icon"></i>
                    <h6 class="fw-bold mb-0">Kuliner & Makanan</h6>
                </a>
            </div>
            <div class="col">
                <a href="#" class="category-card py-4">
                    <i class="fa-solid fa-shirt category-icon"></i>
                    <h6 class="fw-bold mb-0">Fashion & Pakaian</h6>
                </a>
            </div>
            <div class="col">
                <a href="#" class="category-card py-4">
                    <i class="fa-solid fa-gem category-icon"></i>
                    <h6 class="fw-bold mb-0">Kriya & Kerajinan</h6>
                </a>
            </div>
            <div class="col">
                <a href="#" class="category-card py-4">
                    <i class="fa-solid fa-handshake category-icon"></i>
                    <h6 class="fw-bold mb-0">Jasa & Lainnya</h6>
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container mt-5 pt-4 mb-5">
        
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title mb-0">Produk Unggulan</h2>
                <p class="text-muted mt-2">Koleksi kurasi terbaik dari SemarangpreneurUP</p>
            </div>
            <a href="<?= Url::to(['/catalog/default/index']) ?>" class="btn btn-outline-dark rounded-pill px-4">Lihat Semua <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mt-2">
            
            <?php if (!empty($featuredProducts)): ?>
                <?php foreach ($featuredProducts as $product): ?>
                    <?php 
                        $primaryImage = 'https://via.placeholder.com/600x600?text=No+Image';
                        if (!empty($product->productImages)) {
                            foreach ($product->productImages as $img) {
                                if ($img->is_primary) {
                                    $primaryImage = $img->image_path;
                                    break;
                                }
                            }
                            if ($primaryImage === 'https://via.placeholder.com/600x600?text=No+Image') {
                                $primaryImage = $product->productImages[0]->image_path;
                            }
                        }
                    ?>
                    <div class="col">
                        <div class="product-card">
                            <?php if ($product->is_featured): ?>
                                <span class="badge-featured"><i class="fa-solid fa-star me-1"></i> Unggulan</span>
                            <?php endif; ?>
                            <div class="product-img-wrap" style="position: relative; overflow: hidden; padding-top: 100%;">
                                <img src="<?= Html::encode($primaryImage) ?>" alt="<?= Html::encode($product->name) ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="product-body" style="padding: 1.25rem;">
                                <div class="product-category" style="font-size: 0.8rem; color: #888; text-transform: uppercase; font-weight: 600; margin-bottom: 0.4rem;">
                                    <?= $product->category ? Html::encode($product->category->name) : 'Lainnya' ?>
                                </div>
                                <a href="<?= Url::to(['/catalog/default/detail', 'slug' => $product->slug]) ?>" class="product-title" style="font-weight: 700; font-size: 1.05rem; line-height: 1.4; color: #1a1a1a; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-decoration: none; margin-bottom: 0.8rem;">
                                    <?= Html::encode($product->name) ?>
                                </a>
                                <div class="product-price" style="font-weight: 800; font-size: 1.2rem; color: #4a90e2; margin-bottom: 0.8rem;">
                                    Rp <?= number_format($product->price, 0, ',', '.') ?>
                                </div>
                                <div class="product-umkm d-flex justify-content-between align-items-center" style="font-size: 0.85rem;">
                                    <span class="text-truncate" style="max-width: 60%;"><i class="fa-solid fa-store text-warning me-1"></i> <?= $product->umkmProfile ? Html::encode($product->umkmProfile->nama_usaha) : '-' ?></span>
                                    <?php if ($product->umkmProfile && $product->umkmProfile->status_verifikasi == 1): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-check-circle"></i> Terverifikasi</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada produk unggulan yang tersedia saat ini.</p>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
    
    <!-- CTA Banner -->
    <div class="container mb-5 pb-4">
        <div class="p-5 bg-warning bg-opacity-10 rounded-4 border border-warning border-opacity-25" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffc107\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            <div class="row align-items-center">
                <div class="col-md-8 text-center text-md-start mb-4 mb-md-0">
                    <h3 class="fw-bold mb-2">Anda Mengelola Usaha Mikro di Semarang?</h3>
                    <p class="text-dark opacity-75 fs-5 mb-0">Daftarkan usaha Anda sekarang secara gratis dan jangkau lebih banyak pelanggan. Ayo naik kelas bersama!</p>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <?= Html::a('<i class="fa-solid fa-rocket me-2"></i> Daftar Sebagai UMKM', ['/site/signup'], ['class' => 'btn btn-lg btn-warning fw-bold text-dark px-4 py-3 shadow-sm rounded-pill']) ?>
                </div>
            </div>
        </div>
    </div>

</div>
