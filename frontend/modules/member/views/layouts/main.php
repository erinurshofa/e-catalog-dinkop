<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - Dasbor UMKM</title>
    <?php $this->head() ?>
    <style>
        :root {
            --sidebar-width: 280px;
            --topbar-height: 70px;
            --primary-yellow: #ffc107;
            --primary-dark-yellow: #e0a800;
        }
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            background-color: #fff;
            box-shadow: 2px 0 15px rgba(0,0,0,0.05);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }
        .sidebar-header {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 193, 7, 0.1);
            border-bottom: 1px solid rgba(255, 193, 7, 0.2);
        }
        .sidebar-header a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-family: 'Arial Narrow', sans-serif;
            font-weight: 900;
        }
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding-top: 20px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 14px 24px;
            color: #4b5259;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            position: relative;
        }
        .sidebar-link:hover {
            color: var(--primary-dark-yellow);
            background-color: #fafbfc;
        }
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: transparent;
            border-radius: 0 4px 4px 0;
            transition: 0.2s;
        }
        .sidebar-link.active {
            color: var(--primary-dark-yellow);
            background-color: rgba(255,193,7,0.08);
        }
        .sidebar-link.active::before {
            background-color: var(--primary-yellow);
        }
        .sidebar-link i {
            width: 28px;
            font-size: 1.25rem;
            margin-right: 12px;
            text-align: center;
            opacity: 0.8;
        }
        .sidebar-link.active i {
            opacity: 1;
        }
        .topbar {
            height: var(--topbar-height);
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 1020;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .sidebar-toggler {
            background: transparent;
            border: none;
            color: #6c757d;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: background-color 0.2s;
        }
        .sidebar-toggler:hover {
            background-color: #f8f9fa;
            color: var(--primary-dark-yellow);
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: calc(var(--topbar-height) + 30px) 30px 30px;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0,0,0,0.5);
            z-index: 1025;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Desktop Mode (Sidebar can be collapsed) */
        @media (min-width: 992px) {
            body.sidebar-collapsed .sidebar {
                transform: translateX(-100%);
            }
            body.sidebar-collapsed .topbar {
                left: 0;
            }
            body.sidebar-collapsed .main-content {
                margin-left: 0;
            }
        }

        /* Tablet & Mobile Mode (Sidebar hidden by default) */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .topbar {
                left: 0;
                padding: 0 20px;
            }
            .main-content {
                margin-left: 0;
                padding: calc(var(--topbar-height) + 20px) 20px 20px;
            }
            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }
        }
     </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<!-- Topbar -->
<header class="topbar">
    <div class="topbar-left">
        <button class="sidebar-toggler shadow-sm" id="sidebar-toggler" aria-label="Toggle Sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <h5 class="mb-0 fw-bold text-dark d-none d-md-block">Dasbor Pengelola UMKM</h5>
    </div>
    <div class="d-flex align-items-center">
        <span class="me-3 fw-medium d-none d-sm-block">Halo, <?= Yii::$app->user->identity->username ?>!</span>
        <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex']) ?>
        <?= Html::submitButton('<i class="fa-solid fa-sign-out-alt"></i> Keluar', ['class' => 'btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold']) ?>
        <?= Html::endForm() ?>
    </div>
</header>

<!-- Sidebar Navigation -->
<div class="sidebar" id="sidebar">
    <!-- Brand Logo -->
    <div class="sidebar-header" style="height: 85px;">
        <a href="<?= Yii::$app->homeUrl ?>" class="d-flex flex-column align-items-center justify-content-center text-decoration-none h-100">
            <span class="text-warning fw-bolder fst-italic shadow-sm" style="font-size: 1.4rem; letter-spacing: 1px; transform: rotate(-3deg); margin-bottom: 2px; text-shadow: 1px 1px 0px rgba(0,0,0,0.1);">SEMAR</span>
            <span class="text-danger fw-bolder fst-italic" style="font-size: 1.1rem; letter-spacing: 2px; transform: rotate(-3deg);">PRENEURUP</span>
        </a>
    </div>

    <?php
    $umkmProfile = \common\models\UmkmProfile::findOne(['user_id' => Yii::$app->user->id]);
    $isVerified = $umkmProfile && $umkmProfile->status_verifikasi == 1;
    ?>

    <div class="sidebar-content">
        <div class="px-4 pb-3 mb-3 border-bottom text-center">
            <div class="rounded-circle bg-light d-inline-flex justify-content-center align-items-center mb-2 shadow-sm" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-store fa-2x text-muted"></i>
            </div>
            <h6 class="fw-bold mb-0 text-dark">Usaha Mikro</h6>
            <small class="text-success"><i class="fa-solid fa-circle text-success" style="font-size: 8px;"></i> Online</small>
        </div>

        <a href="<?= \yii\helpers\Url::to(['/member/default/index']) ?>" class="sidebar-link <?= Yii::$app->controller->id == 'default' ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-line"></i> 
            <span>Ringkasan Dasbor</span>
        </a>
        
        <?php if ($isVerified): ?>
        <a href="<?= \yii\helpers\Url::to(['/member/product/index']) ?>" class="sidebar-link <?= Yii::$app->controller->id == 'product' ? 'active' : '' ?>">
            <i class="fa-solid fa-box-open"></i> 
            <span>Produk Saya</span>
        </a>
        <?php else: ?>
        <a href="#" class="sidebar-link text-muted" onclick="alert('Menu Produk Saya baru dapat diakses setelah akun UMKM Anda diverifikasi oleh Admin Dinkop.'); return false;" title="Akses terkunci. Menunggu Verifikasi">
            <i class="fa-solid fa-lock text-secondary"></i> 
            <span>Produk Saya (Terkunci)</span>
        </a>
        <?php endif; ?>
        <a href="<?= \yii\helpers\Url::to(['/member/profile/update']) ?>" class="sidebar-link <?= Yii::$app->controller->id == 'profile' ? 'active' : '' ?>">
            <i class="fa-solid fa-store"></i> 
            <span>Profil Toko</span>
        </a>
        <a href="<?= \yii\helpers\Url::to(['/member/legalitas/index']) ?>" class="sidebar-link <?= Yii::$app->controller->id == 'legalitas' ? 'active' : '' ?>">
            <i class="fa-solid fa-file-contract text-info"></i> 
            <span>Dokumen Legalitas</span>
        </a>
    </div>
</div>

<!-- Main Content Area -->
<main role="main" class="main-content" id="main-content">
    <?= Alert::widget() ?>
    <?= $content ?>
</main>

<?php
$js = <<<JS
document.addEventListener('DOMContentLoaded', function() {
    const toggler = document.getElementById('sidebar-toggler');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const body = document.body;

    function toggleSidebar() {
        if (!sidebar || !overlay) return;
        
        if (window.innerWidth < 992) {
            // Mobile/Tablet mode - drawer overlap
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : ''; // Prevent body scroll
        } else {
            // Desktop mode - collapse mode
            body.classList.toggle('sidebar-collapsed');
        }
    }

    if (toggler) {
        toggler.addEventListener('click', toggleSidebar);
    }
    
    // Close sidebar when clicking overlay on mobile
    if (overlay) {
        overlay.addEventListener('click', function() {
            if (sidebar) sidebar.classList.remove('show');
            overlay.classList.remove('show');
            body.style.overflow = '';
        });
    }

    // Handle window resize gracefully
    window.addEventListener('resize', function() {
        if (!sidebar || !overlay) return;
        
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            body.style.overflow = '';
        } else {
            body.classList.remove('sidebar-collapsed');
        }
    });
});
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>
