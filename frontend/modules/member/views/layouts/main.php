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
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            padding: 80px 0 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            background-color: #fff;
            transition: all 0.3s ease;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #495057;
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s;
            border-left: 4px solid transparent;
        }
        .sidebar-link:hover {
            background-color: rgba(255,193,7,0.1);
            color: var(--primary-dark-yellow);
        }
        .sidebar-link.active {
            background-color: rgba(255,193,7,0.15);
            color: var(--primary-dark-yellow);
            border-left-color: var(--primary-yellow);
            font-weight: 600;
        }
        .sidebar-link i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        .main-content {
            margin-left: 280px;
            padding: 90px 30px 30px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .topbar {
            height: 65px;
            position: fixed;
            top: 0;
            right: 0;
            left: 280px;
            z-index: 99;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand-logo-sidebar {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 65px;
            background: rgba(255, 193, 7, 0.15); /* Kuning Transparan */
            border-bottom: 1px solid rgba(255, 193, 7, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 101;
        }
        .brand-logo-sidebar a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-family: 'Arial Narrow', sans-serif;
            font-weight: 900;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <!-- Brand Logo -->
    <div class="brand-logo-sidebar shadow-sm">
        <a href="<?= Yii::$app->homeUrl ?>">
            <span style="font-size: 1.4rem;">Semar</span>
            <span class="text-danger" style="font-size: 1.6rem; transform: rotate(-5deg); margin-left: -5px; margin-top: 5px;">PreneurUP</span>
        </a>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <div>
            <h5 class="mb-0 fw-bold text-dark d-none d-md-block">Dasbor Pengelola UMKM</h5>
        </div>
        <div class="d-flex align-items-center">
            <span class="me-3 fw-medium">Halo, <?= Yii::$app->user->identity->username ?>!</span>
            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex']) ?>
            <?= Html::submitButton('<i class="fa-solid fa-sign-out-alt"></i> Keluar', ['class' => 'btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold']) ?>
            <?= Html::endForm() ?>
        </div>
    </div>
</header>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <div class="px-4 pb-3 mb-3 border-bottom text-center">
        <div class="rounded-circle bg-light d-inline-flex justify-content-center align-items-center mb-2" style="width: 60px; height: 60px;">
            <i class="fa-solid fa-store fa-2x text-muted"></i>
        </div>
        <h6 class="fw-bold mb-0">Usaha Mikro</h6>
        <small class="text-success"><i class="fa-solid fa-circle text-success" style="font-size: 8px;"></i> Online</small>
    </div>

    <a href="<?= \yii\helpers\Url::to(['/member/default/index']) ?>" class="sidebar-link <?= Yii::$app->controller->id == 'default' ? 'active' : '' ?>">
        <i class="fa-solid fa-chart-line"></i> 
        <span>Ringkasan Dasbor</span>
    </a>
    <a href="<?= \yii\helpers\Url::to(['/member/product/index']) ?>" class="sidebar-link <?= Yii::$app->controller->id == 'product' ? 'active' : '' ?>">
        <i class="fa-solid fa-box-open"></i> 
        <span>Produk Saya</span>
    </a>
    <a href="<?= \yii\helpers\Url::to(['/member/profile/update']) ?>" class="sidebar-link <?= Yii::$app->controller->id == 'profile' ? 'active' : '' ?>">
        <i class="fa-solid fa-store"></i> 
        <span>Profil Toko</span>
    </a>
    <a href="#" class="sidebar-link">
        <i class="fa-solid fa-file-contract"></i> 
        <span>Dokumen Legalitas</span>
    </a>
</div>

<!-- Main Content Area -->
<main role="main" class="main-content">
    <?= Alert::widget() ?>
    <?= $content ?>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>
