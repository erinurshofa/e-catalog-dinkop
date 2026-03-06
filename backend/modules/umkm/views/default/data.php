<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UmkmProfileSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Database UMKM';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    .admin-card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }
    .search-box {
        background-color: #f8fafc;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid #e2e8f0;
    }
    .grid-view table {
        border-collapse: separate;
        border-spacing: 0;
    }
    .grid-view th {
        background-color: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #475569;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
    }
    .grid-view td {
        vertical-align: middle;
        padding: 1rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        background-color: white;
    }
    .status-badge {
        padding: 0.35rem 0.6rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .status-active { background-color: #dcfce7; color: #15803d; }
    .status-pending { background-color: #fef3c7; color: #d97706; }
    .status-rejected { background-color: #fee2e2; color: #b91c1c; }
");
?>
<div class="umkm-profile-data">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="mb-1 fw-bold text-dark"><i class="fa-solid fa-users text-primary me-2"></i> Pencarian & Data UMKM</h3>
            <p class="text-muted mb-0">Kelola dan cari data diri, data usaha, hingga data keuangan dari seluruh UMKM terdaftar.</p>
        </div>
    </div>

    <!-- PENCARIAN -->
    <div class="search-box">
        <?php $form = \yii\bootstrap5\ActiveForm::begin([
            'action' => ['data'],
            'method' => 'get',
            'options' => ['class' => 'row g-3'],
        ]); ?>
        
        <div class="col-md-4">
            <?= $form->field($searchModel, 'nama_usaha')->textInput(['placeholder' => 'Cari nama usaha...', 'class' => 'form-control'])->label('Nama Usaha') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($searchModel, 'nik')->textInput(['placeholder' => 'Cari NIK...', 'class' => 'form-control'])->label('Nomor NIK') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($searchModel, 'status_verifikasi')->dropDownList([
                '' => 'Semua Status',
                '0' => 'Pending (Menunggu)',
                '1' => 'Aktif (Disetujui)',
                '2' => 'Ditolak'
            ], ['class' => 'form-select'])->label('Status Verifikasi') ?>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="fa-solid fa-search me-1"></i> Cari</button>
        </div>

        <?php \yii\bootstrap5\ActiveForm::end(); ?>
    </div>

    <!-- TABEL DATA -->
    <div class="card admin-card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n<div class='p-3 border-top d-flex justify-content-between align-items-center'>{summary}\n{pager}</div>",
                    'tableOptions' => ['class' => 'table table-hover mb-0 w-100'],
                    'pager' => [
                        'class' => \yii\bootstrap5\LinkPager::class,
                        'options' => ['class' => 'pagination justify-content-end mb-0'],
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'nama_usaha',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<div class="fw-bold text-dark">' . Html::encode($model->nama_usaha) . '</div>' .
                                       '<div class="small text-muted"><i class="fa-solid fa-user me-1"></i> ' . Html::encode($model->user->username ?? '-') . '</div>';
                            },
                        ],
                        'nik',
                        [
                            'attribute' => 'no_whatsapp',
                            'label' => 'No. WA',
                        ],
                        [
                            'attribute' => 'status_verifikasi',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->status_verifikasi == 1) return '<span class="status-badge status-active">Aktif</span>';
                                if ($model->status_verifikasi == 2) return '<span class="status-badge status-rejected">Ditolak</span>';
                                return '<span class="status-badge status-pending">Pending</span>';
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Aksi',
                            'template' => '{view}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa-solid fa-id-card"></i> Data Lengkap', ['view', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-outline-primary shadow-sm',
                                        'title' => 'Lihat Detail 4 Data Indikator',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
