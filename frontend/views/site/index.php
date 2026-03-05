<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

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
                    
                    <div class="search-box-hero rounded-pill bg-white d-flex overflow-hidden mt-4">
                        <input type="text" class="form-control border-0 shadow-none w-100" placeholder="Cari produk impian Anda di sini..." aria-label="Search">
                        <button class="btn px-4 bg-warning" type="button">
                            <i class="fa-solid fa-search"></i> Cari
                        </button>
                    </div>
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
            <a href="#" class="btn btn-outline-dark rounded-pill px-4">Lihat Semua <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mt-2">
            
            <!-- Dummy Product 1 -->
            <div class="col">
                <div class="product-card">
                    <span class="badge-featured"><i class="fa-solid fa-star me-1"></i> Unggulan</span>
                    <div class="product-img-wrap">
                        <img src="<?= Yii::getAlias('@web') ?>/images/lumpia_semarang_sample_1772688185608.png" alt="Lumpia">
                    </div>
                    <div class="product-body">
                        <div class="product-category">Kuliner</div>
                        <a href="#" class="product-title">Lumpia Semarang Asli Mbak Lien Premium Box (Isi 10)</a>
                        <div class="product-price">Rp 150.000</div>
                        <div class="product-umkm d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-store text-warning me-1"></i> Lumpia Mbak Lien</span>
                            <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-check-circle"></i> Terverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dummy Product 2 -->
            <div class="col">
                <div class="product-card">
                    <div class="product-img-wrap">
                        <img src="<?= Yii::getAlias('@web') ?>/images/batik_semarang_sample_1772688166356.png" alt="Batik">
                    </div>
                    <div class="product-body">
                        <div class="product-category">Fashion</div>
                        <a href="#" class="product-title">Kemeja Batik Tulis Khas Semarangan Motif Tugu Muda</a>
                        <div class="product-price">Rp 350.000</div>
                        <div class="product-umkm d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-store text-warning me-1"></i> Batik Jaya</span>
                            <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-check-circle"></i> Terverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dummy Product 3 -->
            <div class="col">
                <div class="product-card">
                    <span class="badge-featured"><i class="fa-solid fa-star me-1"></i> Unggulan</span>
                    <div class="product-img-wrap">
                        <img src="<?= Yii::getAlias('@web') ?>/images/bandeng_presto_sample_1772688291160.png" alt="Bandeng">
                    </div>
                    <div class="product-body">
                        <div class="product-category">Kuliner</div>
                        <a href="#" class="product-title">Bandeng Presto Juwana Super Lembut Dus Kecil</a>
                        <div class="product-price">Rp 75.000</div>
                        <div class="product-umkm d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-store text-warning me-1"></i> Bandeng Makmur</span>
                            <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-check-circle"></i> Terverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dummy Product 4 -->
            <div class="col">
                <div class="product-card">
                    <div class="product-img-wrap">
                        <img src="<?= Yii::getAlias('@web') ?>/images/kerajinan_jati_sample_1772688663853.png" alt="Kerajinan">
                    </div>
                    <div class="product-body">
                        <div class="product-category">Kriya</div>
                        <a href="#" class="product-title">Hiasan Dinding Kayu Jati Motif Kota Lama Semarang</a>
                        <div class="product-price">Rp 220.000</div>
                        <div class="product-umkm d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-store text-warning me-1"></i> Kriya Jati</span>
                            <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-check-circle"></i> Terverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>
            
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
