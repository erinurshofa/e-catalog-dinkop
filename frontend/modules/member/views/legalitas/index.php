<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dokumen Legalitas Administrasi';
?>
<div class="legalitas-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="fa-solid fa-file-contract text-info me-2"></i> <?= Html::encode($this->title) ?></h3>
            <p class="text-muted mb-0">Kelola dan lengkapi dokumen izin usaha (NIB, NPWP, Sertifikasi Halal, PIRT, dll).</p>
        </div>
        <?= Html::a('<i class="fa-solid fa-cloud-arrow-up me-1"></i> Unggah Dokumen Baru', ['create'], ['class' => 'btn btn-info fw-bold rounded-pill px-4 shadow-sm text-white']) ?>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                'headerRowOptions' => ['class' => 'table-light text-muted small text-uppercase'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['class' => 'ps-4']],

                    [
                        'attribute' => 'jenis_dokumen',
                        'header' => 'Jenis Berkas',
                        'format' => 'raw',
                        'value' => function($model) {
                            return '<span class="fw-bold text-dark"><i class="fa-regular fa-file-pdf text-danger me-2"></i>' . Html::encode($model->jenis_dokumen) . '</span>';
                        }
                    ],
                    'nomor_dokumen',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->status == 1) {
                                return '<span class="badge bg-success rounded-pill px-3 py-2"><i class="fa-solid fa-check me-1"></i> Valid</span>';
                            } elseif ($model->status == 2) {
                                return '<span class="badge bg-danger rounded-pill px-3 py-2"><i class="fa-solid fa-xmark me-1"></i> Ditolak</span>';
                            }
                            return '<span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i class="fa-regular fa-clock me-1"></i> Menunggu Validasi...</span>';
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Tanggal Diunggah',
                        'value' => function($model) {
                            return date('d M Y, H:i', $model->created_at);
                        }
                    ],
                    [
                        'label' => 'File / Berkas',
                        'format' => 'raw',
                        'value' => function($model) {
                            if($model->file_path) {
                                return Html::a('<i class="fa-solid fa-download me-1"></i> Unduh', Yii::getAlias('@web/') . $model->file_path, ['class' => 'btn btn-sm btn-outline-primary rounded-pill', 'target' => '_blank', 'data-pjax' => '0']);
                            }
                            return '<span class="text-muted fst-italic">Tanpa File</span>';
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'contentOptions' => ['class' => 'text-end pe-4'],
                        'headerOptions' => ['class' => 'text-end pe-4'],
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fa-solid fa-trash-can"></i> Hapus Permohonan', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-sm btn-light text-danger fw-bold rounded-pill mx-1',
                                    'data' => [
                                        'confirm' => 'Apakah Anda yakin ingin menghapus berkas ' . $model->jenis_dokumen . ' ini?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
