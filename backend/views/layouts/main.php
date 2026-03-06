<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);

// Get current route to determine active menu
$route = Yii::$app->controller->route;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - Admin DINKOP</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --admin-primary: #1e3c72;
            --admin-secondary: #2a5298;
            --admin-accent: #ffc107;
            --admin-sidebar-bg: #111827;
            --admin-sidebar-hover: #1f2937;
            --admin-sidebar-text: #9ca3af;
            --admin-sidebar-active-text: #ffffff;
            --admin-bg: #f3f4f6;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-bg);
            color: #374151;
            overflow-x: hidden;
        }
        
        /* Layout wrapper */
        .wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: var(--admin-sidebar-bg);
            color: white;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
            z-index: 1040;
            overflow-y: auto;
            flex-shrink: 0;
        }
        .sidebar-brand {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            font-size: 1.25rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            background: rgba(0,0,0,0.1);
        }
        .sidebar-brand:hover {
            color: white;
        }
        .brand-text-semar { color: white; }
        .brand-text-preneur { color: var(--admin-accent); }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
            margin: 0;
            flex-grow: 1;
        }
        .sidebar-menu li {
            padding: 0.25rem 1rem;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            color: var(--admin-sidebar-text);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s;
            font-weight: 500;
        }
        .sidebar-menu a i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 0.75rem;
            text-align: center;
            transition: color 0.2s;
        }
        .sidebar-menu a:hover {
            background: var(--admin-sidebar-hover);
            color: var(--admin-sidebar-active-text);
        }
        .sidebar-menu a:hover i {
            color: var(--admin-accent);
        }
        .sidebar-menu a.active {
            background: linear-gradient(90deg, var(--admin-primary) 0%, var(--admin-secondary) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
        }
        .sidebar-menu a.active i {
            color: var(--admin-accent);
        }

        .sidebar-heading {
            padding: 1rem 1.5rem 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            font-weight: 700;
        }

        /* Content Area */
        .content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            background: var(--admin-bg);
        }

        /* Topbar */
        .topbar {
            background: white;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            z-index: 1030;
            flex-shrink: 0;
        }
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #4b5563;
            cursor: pointer;
        }
        .topbar-user {
            display: flex;
            align-items: center;
        }
        .topbar-user-info {
            text-align: right;
            margin-right: 1rem;
            line-height: 1.2;
        }
        .topbar-user-name {
            font-weight: 700;
            color: #111827;
            font-size: 0.95rem;
        }
        .topbar-user-role {
            font-size: 0.8rem;
            color: #6b7280;
        }
        .topbar-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--admin-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
        }

        /* Main Content Padding */
        .main-content {
            padding: 2rem;
            flex-grow: 1;
        }
        
        /* Premium Card Override for Backend */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #f3f4f6;
            padding: 1.25rem 1.5rem;
            font-weight: 700;
            color: #111827;
        }
        .card-body {
            padding: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar {
                position: fixed;
                left: -280px;
                height: 100vh;
            }
            .sidebar.show {
                left: 0;
            }
            .menu-toggle {
                display: block;
            }
            .main-content {
                padding: 1.5rem;
            }
        }
    </style>
    <?php $this->head() ?>
</head>
<body x-data="{ sidebarOpen: false }" :class="{ 'overflow-hidden': sidebarOpen }">
<?php $this->beginBody() ?>

<div class="wrapper">
    <!-- Overlay for mobile sidebar -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" 
         class="position-fixed top-0 start-0 w-100 h-100 bg-dark opacity-50 z-3 d-lg-none"
         style="display: none; z-index: 1035;"></div>

    <!-- Sidebar -->
    <aside class="sidebar" :class="{ 'show': sidebarOpen }">
        <a href="<?= Url::home() ?>" class="sidebar-brand">
            <i class="fa-solid fa-building-columns me-2 text-warning"></i>
            <div>
                <span class="brand-text-semar">Admin</span><span class="brand-text-preneur">Dinkop</span>
            </div>
        </a>
        
        <ul class="sidebar-menu">
            <div class="sidebar-heading">Menu Utama</div>
            <li>
                <a href="<?= Url::to(['/site/index']) ?>" class="<?= ($route == 'site/index') ? 'active' : '' ?>">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            
            <div class="sidebar-heading mt-3">Verifikasi & Kurasi</div>
            <li>
                <a href="<?= Url::to(['/umkm/default/index']) ?>" class="<?= (strpos($route, 'umkm/') === 0 && strpos($route, 'umkm/default/data') === false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-check"></i> Verifikasi Akun UMKM
                </a>
            </li>
            <li>
                <a href="<?= Url::to(['/product/default/review']) ?>" class="<?= (strpos($route, 'product/') === 0) ? 'active' : '' ?>">
                    <i class="fa-solid fa-box-open"></i> Review Produk
                </a>
            </li>
            
            <div class="sidebar-heading mt-3">Data Pokok</div>
            <li>
                <a href="<?= Url::to(['/umkm/default/data']) ?>" class="<?= ($route == 'umkm/default/data') ? 'active' : '' ?>">
                    <i class="fa-solid fa-database"></i> Database UMKM
                </a>
            </li>
            <li>
                <a href="<?= Url::to(['/category']) ?>" class="<?= (strpos($route, 'category') === 0) ? 'active' : '' ?>">
                    <i class="fa-solid fa-tags"></i> Kategori Master
                </a>
            </li>
        </ul>
        
        <div class="p-4 mt-auto border-top" style="border-color: rgba(255,255,255,0.05) !important;">
            <div class="d-flex align-items-center mb-3">
                <div class="topbar-avatar flex-shrink-0" style="width: 35px; height: 35px; font-size: 1rem;">
                    A
                </div>
                <div class="mx-2 text-truncate">
                    <div class="fw-bold text-white small text-truncate"><?= Yii::$app->user->isGuest ? 'Guest' : Html::encode(Yii::$app->user->identity->username) ?></div>
                    <div class="text-muted" style="font-size: 0.7rem;">Kurator Dinkop</div>
                </div>
            </div>
            
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-block w-100']) ?>
                <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar
                </button>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div class="d-flex align-items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="menu-toggle me-3">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="fs-5 fw-bold text-dark d-none d-md-block">
                    Dasbor Kurator
                </div>
            </div>
            
            <div class="topbar-user">
                <a href="<?= Url::to('@web/../../frontend/web/index.php') ?>" target="_blank" class="btn btn-light rounded-pill px-3 me-3 text-muted btn-sm d-none d-sm-inline-flex align-items-center">
                    <i class="fa-solid fa-globe me-1"></i> Lihat Web
                </a>
                
                <div class="topbar-user-info d-none d-sm-block">
                    <div class="topbar-user-name">Tim Kurator Dinkop</div>
                    <div class="topbar-user-role"><?= date('l, d M Y') ?></div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container-fluid px-0">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => ['class' => 'breadcrumb bg-transparent p-0 mb-4 fw-medium text-muted small']
                ]) ?>
                
                <?= Alert::widget() ?>
                
                <?= $content ?>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="mt-auto py-3 text-center text-muted small">
            <div class="container-fluid">
                &copy; <?= date('Y') ?> Dinas Koperasi dan Usaha Mikro Kota Semarang. Diselenggarakan oleh Pemerintah Kota Semarang.
            </div>
        </footer>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
