<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ProductsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Review Produk UMKM';
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
    .product-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 0.5rem;
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
        display: inline-flex;
        align-items: center;
    }
    .status-active { background-color: #dcfce7; color: #15803d; }
    .status-pending { background-color: #fef3c7; color: #d97706; }
    .status-rejected { background-color: #fee2e2; color: #b91c1c; }
    .featured-badge {
        background-color: #fce8eb;
        color: #e11d48;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: bold;
        text-transform: uppercase;
        margin-left: 0.5rem;
    }
    .action-btn-group {
        display: flex;
        gap: 0.5rem;
    }
");
?>
<div class="product-review">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="mb-1 fw-bold text-dark"><i class="fa-solid fa-box-open text-danger me-2"></i> Review & Kurasi Produk</h3>
            <p class="text-muted mb-0">Tinjau produk yang diunggah oleh UMKM sebelum ditampilkan ke katalog publik.</p>
        </div>
    </div>

    <!-- PENCARIAN -->
    <div class="search-box">
        <?php $form = \yii\bootstrap5\ActiveForm::begin([
            'action' => ['review'],
            'method' => 'get',
            'options' => ['class' => 'row g-3'],
        ]); ?>
        
        <div class="col-md-3">
            <?= $form->field($searchModel, 'name')->textInput(['placeholder' => 'Cari nama produk...', 'class' => 'form-control'])->label('Nama Produk') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($searchModel, 'status')->dropDownList([
                '' => 'Semua Status',
                '0' => 'Pending Review',
                '1' => 'Disetujui (Aktif)',
                '2' => 'Ditolak'
            ], ['class' => 'form-select'])->label('Status') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($searchModel, 'is_featured')->dropDownList([
                '' => 'Semua',
                '1' => 'Produk Unggulan',
                '0' => 'Non-Unggulan'
            ], ['class' => 'form-select'])->label('Label Unggulan') ?>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="fa-solid fa-search me-1"></i> Cari</button>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <?= Html::a('<i class="fa-solid fa-rotate-right me-1"></i> Reset', ['review'], ['class' => 'btn btn-outline-secondary w-100']) ?>
        </div>

        <?php \yii\bootstrap5\ActiveForm::end(); ?>
    </div>

    <!-- TABEL PRODUK -->
    <div class="card admin-card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n<div class='p-3 border-top d-flex justify-content-between align-items-center'>{summary}\n{pager}</div>",
                    'tableOptions' => ['class' => 'table table-hover align-middle mb-0 w-100'],
                    'pager' => [
                        'class' => \yii\bootstrap5\LinkPager::class,
                        'options' => ['class' => 'pagination justify-content-end mb-0'],
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        
                        [
                            'label' => 'Gambar',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 80px; text-align: center;'],
                            'value' => function ($model) {
                                $images = $model->productImages;
                                if (!empty($images)) {
                                    $path = $images[0]->image_path;
                                    $imgSrc = strpos($path, 'http') === 0 ? $path : Url::to('@web/../../frontend/web/' . $path);
                                } else {
                                    $imgSrc = Url::to('@web/../../frontend/web/images/placeholder.jpg');
                                }
                                return Html::img($imgSrc, ['class' => 'product-thumb', 'alt' => $model->name]);
                            },
                        ],
                        [
                            'attribute' => 'name',
                            'label' => 'Produk & UMKM',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $featured = $model->is_featured ? '<span class="featured-badge" title="Tampil di Beranda"><i class="fa-solid fa-star"></i> Unggulan</span>' : '';
                                $content = '<div class="fw-bold text-dark fs-6 mb-1">' . Html::encode($model->name) . $featured . '</div>';
                                
                                $umkmName = $model->umkmProfile ? Html::encode($model->umkmProfile->nama_usaha) : '<span class="text-danger fst-italic">Unknown UMKM</span>';
                                $content .= '<div class="small"><i class="fa-solid fa-store text-muted me-1"></i> ' . $umkmName . '</div>';
                                
                                return $content;
                            },
                        ],
                        [
                            'attribute' => 'category_id',
                            'label' => 'Kategori',
                            'value' => function ($model) {
                                return $model->category ? $model->category->name : '-';
                            },
                        ],
                        [
                            'attribute' => 'price',
                            'label' => 'Harga',
                            'value' => function ($model) {
                                return 'Rp ' . number_format($model->price, 0, ',', '.');
                            },
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->status == 1) return '<span class="status-badge status-active"><i class="fa-solid fa-check-circle me-1"></i> Disetujui</span>';
                                if ($model->status == 2) return '<span class="status-badge status-rejected"><i class="fa-solid fa-times-circle me-1"></i> Ditolak</span>';
                                return '<span class="status-badge status-pending"><i class="fa-solid fa-clock me-1"></i> Pending</span>';
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Verifikasi',
                            'template' => '<div class="action-btn-group">{view} {approve} {reject} {feature}</div>',
                            'contentOptions' => ['style' => 'width: 150px; text-align: right;'],
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    $link = Url::to('@web/../../frontend/web/index.php?r=catalog/default/detail&slug=' . $model->slug);
                                    return Html::a('<i class="fa-solid fa-eye"></i>', $link, [
                                        'class' => 'btn btn-sm btn-outline-info shadow-sm bg-white',
                                        'title' => 'Lihat Produk (Simulasi)',
                                        'target' => '_blank',
                                    ]);
                                },
                                'approve' => function ($url, $model, $key) {
                                    if ($model->status == 1) return '';
                                    return Html::a('<i class="fa-solid fa-check"></i>', ['set-status', 'id' => $model->id, 'status' => 1], [
                                        'class' => 'btn btn-sm btn-success shadow-sm',
                                        'title' => 'Setujui Produk',
                                        'data' => [
                                            'confirm' => 'Setujui produk ini untuk tampil di katalog?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },
                                'reject' => function ($url, $model, $key) {
                                    if ($model->status == 2) return '';
                                    return Html::a('<i class="fa-solid fa-xmark"></i>', ['set-status', 'id' => $model->id, 'status' => 2], [
                                        'class' => 'btn btn-sm btn-danger shadow-sm',
                                        'title' => 'Tolak Produk',
                                        'data' => [
                                            'confirm' => 'Tolak produk ini?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },
                                'feature' => function ($url, $model, $key) {
                                    if ($model->status != 1) return ''; // Hanya tampilkan fitur unggulan jika produk aktif
                                    
                                    $icon = $model->is_featured ? '<i class="fa-solid fa-star-slash"></i>' : '<i class="fa-solid fa-star"></i>';
                                    $title = $model->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan';
                                    $btnClass = $model->is_featured ? 'btn-outline-warning text-dark' : 'btn-warning';
                                    
                                    return Html::a($icon, ['toggle-featured', 'id' => $model->id], [
                                        'class' => "btn btn-sm {$btnClass} shadow-sm",
                                        'title' => $title,
                                        'data' => [
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
</div>
