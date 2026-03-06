<?php

/** @var yii\web\View $this */
/** @var int $totalUmkm */
/** @var int $pendingUmkm */
/** @var int $totalProducts */
/** @var int $pendingProducts */
/** @var common\models\UmkmProfile[] $recentPendingUmkm */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Dashboard Kurator DINKOP';
$this->params['breadcrumbs'][] = 'Dashboard';

$this->registerCss("
    .kpi-card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: transform 0.2s;
    }
    .kpi-card:hover {
        transform: translateY(-3px);
    }
    .kpi-icon-wrap {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }
    .kpi-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    .kpi-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }
");
?>
<div class="site-index">

    <!-- KPI Row -->
    <div class="row g-4 mb-4">
        <!-- Total UMKM -->
        <div class="col-xl-3 col-md-6">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="kpi-icon-wrap bg-primary bg-opacity-10 text-primary">
                            <i class="fa-solid fa-store"></i>
                        </div>
                    </div>
                    <div class="kpi-value text-dark"><?= number_format($totalUmkm) ?></div>
                    <div class="kpi-label">Total UMKM Terdaftar</div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                    <a href="<?= Url::to(['/umkm/default/data']) ?>" class="text-primary text-decoration-none small fw-bold">Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Pending UMKM -->
        <div class="col-xl-3 col-md-6">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="kpi-icon-wrap bg-warning bg-opacity-10 text-warning">
                            <i class="fa-solid fa-user-clock"></i>
                        </div>
                    </div>
                    <div class="kpi-value text-dark"><?= number_format($pendingUmkm) ?></div>
                    <div class="kpi-label">UMKM Menunggu Verifikasi</div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                    <a href="<?= Url::to(['/umkm/default/index']) ?>" class="text-warning text-decoration-none small fw-bold">Review Sekarang <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-xl-3 col-md-6">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="kpi-icon-wrap bg-success bg-opacity-10 text-success">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>
                    <div class="kpi-value text-dark"><?= number_format($totalProducts) ?></div>
                    <div class="kpi-label">Total Produk Aktif</div>
                </div>
            </div>
        </div>

        <!-- Pending Products -->
        <div class="col-xl-3 col-md-6">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="kpi-icon-wrap bg-danger bg-opacity-10 text-danger">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                    </div>
                    <div class="kpi-value text-dark"><?= number_format($pendingProducts) ?></div>
                    <div class="kpi-label">Produk Perlu Direview</div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                    <a href="<?= Url::to(['/product/default/review']) ?>" class="text-danger text-decoration-none small fw-bold">Review Sekarang <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-user-check text-warning me-2"></i> UMKM Terbaru (Perlu Verifikasi)</h5>
                    <a href="<?= Url::to(['/umkm/default/index']) ?>" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($recentPendingUmkm)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-muted small">
                                    <tr>
                                        <th class="ps-4">Nama Usaha</th>
                                        <th>Pemilik</th>
                                        <th>Tanggal Daftar</th>
                                        <th class="text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentPendingUmkm as $umkm): ?>
                                    <tr>
                                        <td class="ps-4 fw-medium text-dark"><?= Html::encode($umkm->nama_usaha) ?></td>
                                        <td><?= Html::encode($umkm->user->username) ?></td>
                                        <td><?= Yii::$app->formatter->asDatetime($umkm->created_at, 'php:d M Y, H:i') ?></td>
                                        <td class="text-end pe-4">
                                            <a href="<?= Url::to(['/umkm/default/verify', 'id' => $umkm->id]) ?>" class="btn btn-sm btn-primary rounded-pill px-3">Review</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fa-regular fa-circle-check text-success fs-2 mb-3"></i>
                            <h5 class="text-muted">Tidak ada UMKM yang perlu diverifikasi saat ini.</h5>
                            <p class="text-secondary small">Semua data pendaftaran telah ditinjau.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card h-100">
                <div class="card-header bg-gradient-primary text-dark">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-bolt text-warning me-2"></i> Akses Cepat</h5>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    <a href="<?= Url::to(['/umkm/default/data']) ?>" class="btn btn-light border p-3 text-start d-flex align-items-center">
                        <div class="kpi-icon-wrap bg-info bg-opacity-10 text-info me-3" style="width:40px;height:40px;font-size:1.2rem;">
                            <i class="fa-solid fa-search"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Pencarian Data UMKM</div>
                            <div class="small text-muted">Cari profil lengkap dari seluruh UMKM terdaftar</div>
                        </div>
                    </a>
                    
                    <a href="<?= Url::to(['/product/default/review']) ?>" class="btn btn-light border p-3 text-start d-flex align-items-center">
                        <div class="kpi-icon-wrap bg-danger bg-opacity-10 text-danger me-3" style="width:40px;height:40px;font-size:1.2rem;">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Review Produk Baru</div>
                            <div class="small text-muted">Tinjau produk sebelum tampil di katalog publik</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
