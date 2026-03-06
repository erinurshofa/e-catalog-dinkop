<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\UmkmProfile $model */

$this->title = 'Data UMKM: ' . $model->nama_usaha;
$this->params['breadcrumbs'][] = ['label' => 'Database UMKM', 'url' => ['data']];
$this->params['breadcrumbs'][] = Html::encode($model->nama_usaha);

$this->registerCss("
    .admin-card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }
    .profile-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-radius: 1rem 1rem 0 0;
        padding: 3rem 2rem 2rem;
        color: white;
        position: relative;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        background-color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #1e3c72;
        border: 4px solid rgba(255,255,255,0.2);
        position: absolute;
        bottom: -50px;
        left: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .profile-body {
        padding: 4rem 2rem 2rem;
        background: white;
        border-radius: 0 0 1rem 1rem;
    }
    .nav-tabs-custom {
        border-bottom: 2px solid #e2e8f0;
    }
    .nav-tabs-custom .nav-link {
        color: #64748b;
        font-weight: 600;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 1rem 1.5rem;
        margin-bottom: -2px;
        transition: all 0.2s;
    }
    .nav-tabs-custom .nav-link:hover {
        color: #1e3c72;
        border-color: #cbd5e1;
    }
    .nav-tabs-custom .nav-link.active {
        color: #1e3c72;
        border-color: #1e3c72;
        background: transparent;
    }
    .data-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    .data-value {
        font-size: 1.05rem;
        color: #0f172a;
        font-weight: 500;
        margin-bottom: 1.5rem;
    }
    .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .status-active { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .status-pending { background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .status-rejected { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
");
?>
<div class="umkm-profile-view">

    <div class="d-flex align-items-center mb-4">
        <a href="<?= Url::to(['data']) ?>" class="btn btn-outline-secondary btn-sm me-3 rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h3 class="fw-bold mb-0 text-dark">Data Lengkap UMKM</h3>
        </div>
    </div>

    <div class="admin-card mb-5">
        <!-- Header -->
        <div class="profile-header">
            <div class="d-flex justify-content-between align-items-start" style="padding-left: 120px;">
                <div>
                    <h2 class="fw-bold mb-1"><?= Html::encode($model->nama_usaha) ?></h2>
                    <div class="opacity-75"><i class="fa-solid fa-user me-2"></i> <?= Html::encode($model->user->username ?? 'User') ?></div>
                </div>
                <div>
                    <?php if ($model->status_verifikasi == 1): ?>
                        <span class="status-badge status-active"><i class="fa-solid fa-circle-check me-1"></i> Terverifikasi Aktif</span>
                    <?php elseif ($model->status_verifikasi == 2): ?>
                        <span class="status-badge status-rejected"><i class="fa-solid fa-circle-xmark me-1"></i> Ditolak</span>
                    <?php else: ?>
                        <span class="status-badge status-pending"><i class="fa-solid fa-clock me-1"></i> Menunggu Review</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="profile-avatar">
                <i class="fa-solid fa-store"></i>
            </div>
        </div>

        <div class="profile-body">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs nav-tabs-custom mb-4" id="umkmDataTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="diri-tab" data-bs-toggle="tab" data-bs-target="#diri" type="button" role="tab" aria-controls="diri" aria-selected="true">
                        <i class="fa-regular fa-id-card me-2"></i> Data Diri
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="usaha-tab" data-bs-toggle="tab" data-bs-target="#usaha" type="button" role="tab" aria-controls="usaha" aria-selected="false">
                        <i class="fa-solid fa-briefcase me-2"></i> Data Usaha
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="keuangan-tab" data-bs-toggle="tab" data-bs-target="#keuangan" type="button" role="tab" aria-controls="keuangan" aria-selected="false">
                        <i class="fa-solid fa-wallet me-2"></i> Data Keuangan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="lainnya-tab" data-bs-toggle="tab" data-bs-target="#lainnya" type="button" role="tab" aria-controls="lainnya" aria-selected="false">
                        <i class="fa-solid fa-circle-info me-2"></i> Data Lainnya
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="umkmDataTabContent">
                
                <!-- TAB 1: DATA DIRI -->
                <div class="tab-pane fade show active" id="diri" role="tabpanel" aria-labelledby="diri-tab">
                    <div class="row">
                        <div class="col-md-6 border-end pe-md-4">
                            <h5 class="fw-bold mb-4 text-primary"><i class="fa-solid fa-user-circle me-2"></i> Identitas Pemilik</h5>
                            
                            <div class="data-label">Nama Lengkap (Akun)</div>
                            <div class="data-value"><?= Html::encode($model->user->username ?? '-') ?></div>
                            
                            <div class="data-label">Nomor Induk Kependudukan (NIK)</div>
                            <div class="data-value text-primary fw-bold font-monospace"><?= Html::encode($model->nik ?: '-') ?></div>
                            
                            <div class="data-label">Email Pendaftaran</div>
                            <div class="data-value"><?= Html::encode($model->user->email ?? '-') ?></div>
                        </div>
                        <div class="col-md-6 ps-md-4 mt-4 mt-md-0">
                            <h5 class="fw-bold mb-4 text-primary"><i class="fa-solid fa-map-location-dot me-2"></i> Alamat Pribadi</h5>
                            
                            <div class="data-label">Alamat Domisili</div>
                            <div class="data-value bg-light p-3 rounded border">
                                <?= nl2br(Html::encode($model->alamat_pemilik ?? 'Data alamat belum lengkap')) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: DATA USAHA -->
                <div class="tab-pane fade" id="usaha" role="tabpanel" aria-labelledby="usaha-tab">
                    <div class="row">
                        <div class="col-md-6 border-end pe-md-4">
                            <h5 class="fw-bold mb-4 text-primary"><i class="fa-solid fa-shop me-2"></i> Profil Usaha</h5>
                            
                            <div class="data-label">Nama Usaha</div>
                            <div class="data-value fs-5 text-dark fw-bold"><?= Html::encode($model->nama_usaha) ?></div>
                            
                            <div class="data-label">Alamat Usaha</div>
                            <div class="data-value"><?= nl2br(Html::encode($model->alamat_usaha ?? '-')) ?></div>
                            
                            <div class="data-label">Lokasi Google Map (Lat/Long)</div>
                            <div class="data-value">
                                <?php if ($model->latitude && $model->longitude): ?>
                                    <a href="https://www.google.com/maps/search/?api=1&query=<?= $model->latitude ?>,<?= $model->longitude ?>" target="_blank" class="btn btn-sm btn-outline-primary shadow-sm rounded-pill">
                                        <i class="fa-solid fa-map-pin text-danger"></i> <?= $model->latitude ?>, <?= $model->longitude ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Belum mengatur koordinat peta</span>
                                <?php endif; ?>
                            </div>

                            <div class="data-label mt-4">Kontak WhatsApp UMKM</div>
                            <div class="data-value">
                                <?php if ($model->no_whatsapp): ?>
                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $model->no_whatsapp) ?>" target="_blank" class="text-decoration-none fw-bold text-success border border-success px-3 py-2 rounded-pill bg-success bg-opacity-10">
                                        <i class="fa-brands fa-whatsapp fs-5 align-middle me-1"></i> <?= Html::encode($model->no_whatsapp) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">-</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6 ps-md-4 mt-4 mt-md-0">
                            <h5 class="fw-bold mb-4 text-primary"><i class="fa-solid fa-file-contract me-2"></i> Legalitas & Perizinan</h5>
                            
                            <div class="data-label">Nomor Induk Berusaha (NIB)</div>
                            <div class="data-value">
                                <?php if ($model->nib): ?>
                                    <span class="fw-bold text-dark font-monospace"><?= Html::encode($model->nib) ?></span>
                                    <i class="fa-solid fa-circle-check text-success ms-2" title="Terdata"></i>
                                <?php else: ?>
                                    <span class="text-danger">Belum memiliki NIB</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="data-label">Sertifikat PIRT (Pangan Industri Rumah Tangga)</div>
                            <div class="data-value">
                                <span class="badge bg-secondary text-white fw-medium px-2 py-1"><i class="fa-solid fa-clock"></i> Dalam Proses integrasi Modul Legalitas</span>
                            </div>
                            
                            <div class="data-label">Sertifikat Halal</div>
                            <div class="data-value">
                                <span class="badge bg-secondary text-white fw-medium px-2 py-1"><i class="fa-solid fa-clock"></i> Dalam Proses integrasi Modul Legalitas</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: DATA KEUANGAN -->
                <div class="tab-pane fade" id="keuangan" role="tabpanel" aria-labelledby="keuangan-tab">
                    <div class="py-3 text-center mb-4">
                        <i class="fa-solid fa-chart-pie text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-4">
                            <div class="card bg-light border-0 shadow-sm h-100 text-center p-4">
                                <div class="data-label text-center mb-3"><i class="fa-solid fa-money-bill-wave text-success mb-2 fs-4 d-block"></i> Modal Awal</div>
                                <div class="fs-4 fw-bold text-dark">Lapor Mandiri</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border-0 shadow-sm h-100 text-center p-4">
                                <div class="data-label text-center mb-3"><i class="fa-solid fa-building-columns text-primary mb-2 fs-4 d-block"></i> Nilai Aset</div>
                                <div class="fs-4 fw-bold text-dark">Lapor Mandiri</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border-0 shadow-sm h-100 text-center p-4">
                                <div class="data-label text-center mb-3"><i class="fa-solid fa-arrow-trend-up text-warning mb-2 fs-4 d-block"></i> Omset Per Bulan</div>
                                <div class="fs-4 fw-bold text-dark">
                                    <?= $model->omzet_usaha ? 'Rp ' . number_format($model->omzet_usaha, 0, ',', '.') : '<span class="text-muted fs-6">Belum diisi</span>' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 alert alert-info border-0 bg-info bg-opacity-10 d-flex align-items-center">
                        <i class="fa-solid fa-circle-info fs-4 me-3 text-info"></i>
                        <div>
                            <strong>Catatan:</strong> Pengisian modal awal dan aset akan tersedia pada pembaharuan form profil UMKM berikutnya sesuai spesifikasi. Saat ini sistem mencatat Omset bulanan.
                        </div>
                    </div>
                </div>

                <!-- TAB 4: DATA LAINNYA -->
                <div class="tab-pane fade" id="lainnya" role="tabpanel" aria-labelledby="lainnya-tab">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="fw-bold mb-4 text-primary"><i class="fa-solid fa-list-ul me-2"></i> Informasi Tambahan</h5>
                            
                            <div class="data-label">Kategori Usaha</div>
                            <div class="data-value">
                                <span class="badge bg-primary px-3 py-2 fs-6 fw-normal rounded-pill">
                                    <i class="fa-solid fa-tag me-1"></i> <?= Html::encode($model->kategoriUsaha->name ?? 'Belum dipilih') ?>
                                </span>
                            </div>
                            
                            <div class="data-label">ID Profil (Sistem)</div>
                            <div class="data-value font-monospace">#<?= $model->id ?></div>
                            
                            <div class="data-label">Tanggal Bergabung</div>
                            <div class="data-value"><?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d F Y, H:i') ?> WIB</div>
                            
                            <?php if ($model->updated_at != $model->created_at): ?>
                            <div class="data-label">Pembaruan Profil Terakhir</div>
                            <div class="data-value"><?= Yii::$app->formatter->asDatetime($model->updated_at, 'php:d F Y, H:i') ?> WIB</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
