<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\UmkmProfile $model */

$this->title = 'Review UMKM: ' . $model->nama_usaha;
$this->params['breadcrumbs'][] = ['label' => 'Verifikasi Akun UMKM', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Review';

$this->registerCss("
    .verify-card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }
    .info-label {
        font-size: 0.85rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .info-value {
        font-size: 1.1rem;
        color: #0f172a;
        font-weight: 500;
        margin-bottom: 1.5rem;
    }
    .document-box {
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        border-radius: 0.75rem;
        text-align: center;
        background-color: #f8fafc;
        transition: all 0.2s;
    }
    .document-box:hover {
        border-color: #94a3b8;
        background-color: white;
    }
    .document-box i {
        font-size: 2.5rem;
        color: #475569;
        margin-bottom: 1rem;
    }
    .doc-status {
        font-size: 0.8rem;
        font-weight: bold;
    }
");
?>
<div class="umkm-profile-verify">
    
    <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
        <a href="<?= Url::to(['index']) ?>" class="btn btn-outline-secondary btn-sm me-3 rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h3 class="fw-bold mb-0 text-dark">Review: <?= Html::encode($model->nama_usaha) ?></h3>
            <span class="badge bg-warning text-dark mt-1">Pending Verifikasi</span>
        </div>
    </div>

    <div class="row">
        <!-- Main Info Profile -->
        <div class="col-lg-7">
            <div class="card verify-card mb-4">
                <div class="card-header bg-white pb-0 border-0 pt-4 px-4">
                    <h5 class="fw-bold"><i class="fa-regular fa-id-badge text-primary me-2"></i> Informasi Identitas</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-label">Nama Pemilik / Akun</div>
                            <div class="info-value"><?= Html::encode($model->user->username) ?></div>
                            
                            <div class="info-label">NIK (Nomor Induk Kependudukan)</div>
                            <div class="info-value"><?= Html::encode($model->nik) ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Nama Usaha</div>
                            <div class="info-value fw-bold text-primary"><?= Html::encode($model->nama_usaha) ?></div>
                            
                            <div class="info-label">WhatsApp UMKM</div>
                            <div class="info-value">
                                <?php if ($model->no_whatsapp): ?>
                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $model->no_whatsapp) ?>" target=\"_blank\">
                                        <?= Html::encode($model->no_whatsapp) ?> <i class="fa-brands fa-whatsapp text-success ms-1"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Tidak ada Data</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="info-label">Alamat Lengkap</div>
                            <div class="info-value bg-light p-3 rounded border">
                                <?= nl2br(Html::encode($model->alamat_usaha)) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card verify-card mb-4">
                <div class="card-header bg-white pb-0 border-0 pt-4 px-4">
                    <h5 class="fw-bold"><i class="fa-solid fa-file-contract text-info me-2"></i> Legalitas Dokumen</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="document-box">
                                <i class="fa-regular fa-file-lines"></i>
                                <h6 class="fw-bold mb-1">NIB</h6>
                                <?php if ($model->nib): ?>
                                    <p class="mb-2 text-primary font-monospace"><?= Html::encode($model->nib) ?></p>
                                    <span class="text-success doc-status"><i class="fa-solid fa-check-circle"></i> Diisi</span>
                                <?php else: ?>
                                    <p class="mb-2 text-muted">-</p>
                                    <span class="text-danger doc-status"><i class="fa-solid fa-times-circle"></i> Kosong</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="document-box">
                                <i class="fa-solid fa-certificate"></i>
                                <h6 class="fw-bold mb-1">PIRT / Halal</h6>
                                <?php 
                                    // Asumsi saat ini tidak ada field khusus PIRT/Halal di umkm_profile selain NIB.
                                    // Nanti bisa ditambahkan form ceklis atau melihat tabel umkm_documents
                                ?>
                                <p class="mb-2 text-muted">Lihat Lampiran</p>
                                <button class="btn btn-sm btn-outline-secondary mt-1">Cek File</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Area -->
        <div class="col-lg-5">
            <div class="card verify-card mb-4 border-primary border-2">
                <div class="card-header bg-primary text-white pb-3 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-center"><i class="fa-solid fa-gavel me-2"></i> Keputusan Kurator</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-center text-muted mb-4">Silakan periksa seluruh data dengan teliti. Akun yang disetujui akan langsung mendapatkan akses merilis Produk ke e-Katalog.</p>
                    
                    <div class="d-grid gap-3">
                        <?= Html::a('<i class="fa-solid fa-check fs-5 me-2"></i> Setujui UMKM', ['approve', 'id' => $model->id], [
                            'class' => 'btn btn-success btn-lg py-3 fw-bold shadow-sm',
                            'data' => [
                                'confirm' => 'Apakah Anda yakin ingin menyetujui akun UMKM ini?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        
                        <?= Html::a('<i class="fa-solid fa-xmark fs-5 me-2"></i> Tolak Pendaftaran', ['reject', 'id' => $model->id], [
                            'class' => 'btn btn-outline-danger btn-lg py-3 fw-bold',
                            'data' => [
                                'confirm' => 'Apakah Anda yakin ingin MENOLAK akun UMKM ini? Akun tersebut tidak akan bisa berjualan.',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                    
                    <hr class="my-4">
                    <div class="small text-muted text-center">
                        <i class="fa-solid fa-circle-info text-primary me-1"></i> Saat tombol di atas ditekan, status UMKM akan langsung diperbarui.
                    </div>
                </div>
            </div>
            
            <div class="card verify-card bg-light">
                <div class="card-body p-3 text-center">
                    <div class="small fw-bold text-muted mb-2">Tanggal Pendaftaran</div>
                    <div><?= Yii::$app->formatter->asDatetime($model->created_at, 'php:l, d F Y - H:i') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
