<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Informasi Pendaftaran - SemarangpreneurUP';
$this->params['breadcrumbs'][] = 'Informasi';

// Custom CSS for premium step-by-step information page
$this->registerCss("
    .info-hero {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 4rem 2rem;
        border-radius: 1.5rem;
        margin-bottom: 4rem;
        box-shadow: 0 15px 35px rgba(30, 60, 114, 0.2);
        position: relative;
        overflow: hidden;
        text-align: center;
    }
    .info-hero::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -10%;
        width: 50%;
        height: 200%;
        background: rgba(255,255,255,0.05);
        transform: rotate(15deg);
        pointer-events: none;
    }
    .info-hero h1 {
        font-weight: 800;
        font-size: 2.8rem;
        letter-spacing: -1px;
        margin-bottom: 1rem;
    }
    .info-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Steps Layout */
    .steps-container {
        max-width: 900px;
        margin: 0 auto;
        position: relative;
    }
    
    /* Vertical Line for Desktop */
    @media (min-width: 768px) {
        .steps-container::before {
            content: '';
            position: absolute;
            top: 2rem;
            bottom: 2rem;
            left: 3rem;
            width: 4px;
            background: #e9ecef;
            border-radius: 4px;
            z-index: 0;
        }
    }

    .step-card {
        background: #fff;
        border-radius: 1.5rem;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.02);
        display: flex;
        align-items: flex-start;
        position: relative;
        z-index: 1;
        transition: transform 0.3s ease;
    }
    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0,0,0,0.08);
    }
    
    .step-number {
        flex-shrink: 0;
        width: 6rem;
        height: 6rem;
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 900;
        margin-right: 2rem;
        box-shadow: 0 10px 20px rgba(255, 152, 0, 0.3);
        border: 6px solid #fff;
    }
    
    .step-content {
        flex-grow: 1;
        padding-top: 0.5rem;
    }
    
    .step-title {
        font-weight: 800;
        color: #1a1a1a;
        font-size: 1.8rem;
        margin-bottom: 1rem;
        letter-spacing: -0.5px;
    }
    
    .step-desc {
        color: #555;
        font-size: 1.15rem;
        line-height: 1.7;
        margin-bottom: 0;
    }

    .step-link {
        display: inline-flex;
        align-items: center;
        margin-top: 1rem;
        font-weight: 700;
        color: #1e3c72;
        text-decoration: none;
        background: rgba(30, 60, 114, 0.05);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        transition: all 0.2s;
    }
    .step-link:hover {
        background: #1e3c72;
        color: #fff;
    }

    /* Mobile Adjustments */
    @media (max-width: 767px) {
        .step-card {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 2rem 1.5rem;
        }
        .step-number {
            margin-right: 0;
            margin-bottom: 1.5rem;
        }
        .step-title {
            font-size: 1.5rem;
        }
    }
");
?>
<div class="site-informasi container py-4">

    <!-- Hero Section -->
    <div class="info-hero">
        <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">Panduan Resmi</span>
        <h1>Informasi Pendaftaran dan Verifikasi</h1>
        <p>Langkah mudah untuk bergabung dan mulai mempromosikan produk usaha mikro Anda di SemarangpreneurUP.</p>
    </div>

    <!-- Steps Section -->
    <div class="steps-container">
        
        <!-- Step 1 -->
        <div class="step-card">
            <div class="step-number bg-primary">1</div>
            <div class="step-content">
                <h2 class="step-title text-primary">Pendaftaran & Upload Persyaratan</h2>
                <p class="step-desc">
                    Langkah pertama adalah mengisi formulir pendaftaran dan mengunggah dokumen persyaratan secara online. Pastikan seluruh data yang dimasukkan sesuai dengan identitas usaha Anda.
                </p>
                <a href="http://katalogusahamikro.smg/" target="_blank" class="step-link">
                    <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> katalogusahamikro.smg
                </a>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="step-card">
            <div class="step-number" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); box-shadow: 0 10px 20px rgba(23, 162, 184, 0.3);">2</div>
            <div class="step-content">
                <h2 class="step-title text-info">Verifikasi Dokumen</h2>
                <p class="step-desc">
                    Setelah Anda mengunggah persyaratan, <strong>Tim Kurator</strong> dari Dinas Koperasi dan UMKM akan melakukan verifikasi dan validasi terhadap dokumen yang Anda kirimkan untuk memastikan kelayakan usaha.
                </p>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="step-card">
            <div class="step-number" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3);">3</div>
            <div class="step-content">
                <h2 class="step-title text-success">Aktivasi Akun</h2>
                <p class="step-desc">
                    Bila dokumen Anda memenuhi syarat dan lulus proses kurasi, akun Anda akan diaktifkan. Anda akan diberikan akses penuh ke <strong>Dashboard Admin</strong> untuk mulai mengunggah dan mempromosikan produk Anda di platform SemarangpreneurUP.
                </p>
                <a href="<?= Url::to(['/site/login']) ?>" class="btn btn-success mt-4 rounded-pill px-4 fw-bold shadow-sm">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk ke Dashboard Admin
                </a>
            </div>
        </div>

    </div>

</div>
