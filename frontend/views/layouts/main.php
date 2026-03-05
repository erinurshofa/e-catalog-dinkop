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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => '<div class="custom-brand-logo"><span class="text-semar">Semar</span><span class="text-preneur">PreneurUP</span></div>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-light bg-white fixed-top transition-all',
            'x-bind:class' => "scrolled ? 'shadow-sm py-2' : 'py-3'",
        ],
        'innerContainerOptions' => ['class' => 'container'],
    ]);
    
    $menuItems = [
        ['label' => 'Beranda', 'url' => ['/site/index']],
        ['label' => 'Katalog', 'url' => ['/catalog/default/index']],
        ['label' => 'Informasi', 'url' => ['/site/about']],
    ];
    
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '<i class="fa-solid fa-user-circle me-1"></i> Masuk / Daftar', 'url' => ['/site/login'], 'encode' => false, 'linkOptions' => ['class' => 'btn btn-outline-dark ms-2 rounded-pill px-4']];
    } else {
        $menuItems[] = [
            'label' => 'Dasbor UMKM',
            'url' => ['/member/default/index'],
            'linkOptions' => ['class' => 'btn btn-warning ms-2 rounded-pill px-4 fw-bold']
        ];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Keluar',
                ['class' => 'btn btn-link nav-link text-danger ms-2']
            )
            . Html::endForm()
            . '</li>';
    }
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-md-0 align-items-center'],
        'items' => $menuItems,
    ]);
    
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0 position-relative">
    <div class="position-absolute w-100" style="z-index: 1050; top: 80px; left: 0;">
        <div class="container">
            <?= Alert::widget() ?>
        </div>
    </div>
    <?= $content ?>
</main>

<footer class="main-footer mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5 class="footer-title mb-4">
                    <div class="custom-brand-logo ms-0">
                        <span class="text-semar" style="font-size: 1.25rem;">Semar</span>
                        <span class="text-preneur" style="font-size: 1.5rem;">PreneurUP</span>
                    </div>
                </h5>
                <p class="text-muted mt-2">Platform resmi E-Katalog Produk Usaha Mikro Kota Semarang. Diselenggarakan oleh Pemerintah Kota Semarang.</p>
            </div>
            <div class="col-lg-2 col-md-4 mb-4">
                <h6 class="fw-bold mb-3">Tautan</h6>
                <a href="#" class="footer-link">Beranda</a>
                <a href="#" class="footer-link">Katalog Produk</a>
                <a href="#" class="footer-link">Informasi Pendaftaran</a>
            </div>
            <div class="col-lg-3 col-md-4 mb-4">
                <h6 class="fw-bold mb-3">Kontak DINKOP</h6>
                <p class="text-muted mb-1"><i class="fa-solid fa-map-marker-alt me-2"></i> Gedung Pandanaran Lt 7, Kota Semarang</p>
                <p class="text-muted mb-1"><i class="fa-solid fa-envelope me-2"></i> dinkop@semarangkota.go.id</p>
                <p class="text-muted"><i class="fa-solid fa-phone me-2"></i> (024) 1234567</p>
            </div>
            <div class="col-lg-3 col-md-4 mb-4">
                <h6 class="fw-bold mb-3">Sosial Media</h6>
                <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle me-2"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle me-2"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle fw-bold" style="font-family: Arial, sans-serif;">X</a>
            </div>
        </div>
        <hr class="mt-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-muted mb-0">&copy; <?= date('Y') ?> Dinas Koperasi dan Usaha Mikro Kota Semarang.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <img src="https://semarangkota.go.id/layout/images/logo_smsg_red.png" alt="Logo Pemkot" height="40" style="opacity: 0.6; filter: grayscale(100%);">
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
