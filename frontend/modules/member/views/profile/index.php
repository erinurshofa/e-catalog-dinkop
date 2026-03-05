<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UmkmProfile */

$this->title = 'Profil Toko Saya';
?>
<div class="profile-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="fa-solid fa-store text-warning me-2"></i> <?= Html::encode($this->title) ?></h3>
            <p class="text-muted mb-0">Informasi utama usaha dan data administratif kepemilikan Anda.</p>
        </div>
        <?= Html::a('<i class="fa-solid fa-pen-to-square me-1"></i> Lengkapi Profil / Edit', ['update'], ['class' => 'btn btn-outline-warning fw-bold rounded-pill px-4 shadow-sm text-dark']) ?>
    </div>

    <!-- Status Verifikasi Banner -->
    <?php if ($model->status_verifikasi == 1): ?>
        <div class="alert alert-success border-0 d-flex align-items-center mb-4 rounded-4 shadow-sm">
            <i class="fa-solid fa-circle-check fa-2x text-success me-3"></i>
            <div>
                <h6 class="fw-bold mb-0 text-success-emphasis">Profil Terverifikasi</h6>
                <small>Usaha Anda telah ditinjau dan disetujui oleh Dinas Koperasi. Produk Anda kini dapat Tampil Publik.</small>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning border-0 d-flex align-items-center mb-4 rounded-4 shadow-sm bg-warning bg-opacity-10">
            <i class="fa-solid fa-hourglass-half fa-2x text-warning me-3"></i>
            <div>
                <h6 class="fw-bold mb-0 text-dark">Menunggu Verifikasi</h6>
                <small class="text-dark">Profil ini masih dalam antrean peninjauan oleh Admin DINKOP. Pastikan NIK dan Alamat valid.</small>
            </div>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-address-card me-2 text-primary"></i> Data Kepemilikan & Identitas</h6>
                </div>
                <div class="card-body p-0">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-borderless table-striped mb-0 table-hover'],
                        'template' => '<tr><th class="ps-4 w-35 text-muted fw-normal">{label}</th><td class="pe-4 fw-medium text-dark">{value}</td></tr>',
                        'attributes' => [
                            'nama_pemilik',
                            'nik',
                            'no_whatsapp',
                            'alamat_pemilik:ntext',
                        ],
                    ]) ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-transparent py-3 px-4 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-shop me-2 text-danger"></i> Data Operasional Usaha</h6>
                </div>
                <div class="card-body p-0">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-borderless table-striped mb-0'],
                        'template' => '<tr><th class="ps-4 w-35 text-muted fw-normal">{label}</th><td class="pe-4 fw-medium text-dark">{value}</td></tr>',
                        'attributes' => [
                            'nama_usaha',
                            'nib',
                            [
                                'label' => 'Sektor / Kategori Usaha',
                                'value' => $model->kategoriUsaha ? $model->kategoriUsaha->name : '<span class="text-muted fst-italic">Belum diisi</span>',
                                'format' => 'raw'
                            ],
                            'deskripsi_usaha:ntext',
                            'alamat_usaha:ntext',
                            [
                                'attribute' => 'link_gmaps',
                                'label' => 'Tautan Google Maps',
                                'format' => 'raw',
                                'value' => $model->link_gmaps ? Html::a('Buka di Maps <i class="fa-solid fa-external-link-alt ms-1"></i>', $model->link_gmaps, ['target' => '_blank', 'class' => 'badge bg-danger text-decoration-none']) : '<span class="text-muted fst-italic">Tidak Tersedia</span>'
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-transparent py-3 px-4 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-chart-pie me-2 text-success"></i> Skala Usaha (Opsional)</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <small class="text-muted d-block mb-1">Modal Awal</small>
                        <h5 class="fw-bold text-dark mb-0"><?= $model->modal_awal ? 'Rp ' . number_format($model->modal_awal, 0, ',', '.') : '<span class="text-muted fw-normal fs-6">Belum didata</span>' ?></h5>
                    </div>
                    <div class="mb-4">
                        <small class="text-muted d-block mb-1">Aset Usaha</small>
                        <h5 class="fw-bold text-dark mb-0"><?= $model->aset_usaha ? 'Rp ' . number_format($model->aset_usaha, 0, ',', '.') : '<span class="text-muted fw-normal fs-6">Belum didata</span>' ?></h5>
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">Omzet Rata-rata / Bulan</small>
                        <h5 class="fw-bold text-success mb-0"><?= $model->omzet_usaha ? 'Rp ' . number_format($model->omzet_usaha, 0, ',', '.') : '<span class="text-muted fw-normal fs-6">Belum didata</span>' ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
