<?php

/** @var yii\web\View $this */

$this->title = 'Ringkasan Dasbor';
?>
<div class="member-default-index">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Ikhtisar Usaha Anda</h3>
        <a href="<?= \yii\helpers\Url::to(['/site/index']) ?>" class="btn btn-outline-secondary rounded-pill btn-sm px-3" target="_blank"><i class="fa-solid fa-external-link-alt me-1"></i> Lihat Katalog Publik</a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-box fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Produk</h6>
                        <h3 class="fw-bold mb-0">0</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-eye fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Dilihat</h6>
                        <h3 class="fw-bold mb-0">0 <small class="text-muted fs-6 fw-normal">Kali</small></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-check-circle fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Status Verifikasi</h6>
                        <span class="badge bg-warning text-dark"><i class="fa-regular fa-clock me-1"></i> Menunggu Verifikasi Admin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
            <h5 class="fw-bold">Langkah Selanjutnya</h5>
        </div>
        <div class="card-body p-4">
            <div class="alert alert-info border-0 bg-info bg-opacity-10 d-flex align-items-start mb-0">
                <i class="fa-solid fa-info-circle fa-2x text-info me-3 mt-1"></i>
                <div>
                    <h6 class="fw-bold text-info-emphasis">Lengkapi Profil dan Dokumen Anda!</h6>
                    <p class="mb-2 text-dark">Agar produk Anda dapat ditampilkan di e-Katalog publik, Anda perlu memverifikasi identitas dan legalitas usaha Anda.</p>
                    <a href="#" class="btn btn-sm btn-info text-white fw-bold rounded-pill px-3">Lengkapi Sekarang</a>
                </div>
            </div>
        </div>
    </div>

</div>
