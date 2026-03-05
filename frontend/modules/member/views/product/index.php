<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $profile common\models\UmkmProfile */

$this->title = 'Katalog Produk Saya';
?>
<div class="product-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="fa-solid fa-boxes-stacked text-warning me-2"></i> <?= Html::encode($this->title) ?></h3>
            <p class="text-muted mb-0">Kelola barang jualan dan etalase toko Anda di sini.</p>
        </div>
        <?= Html::a('<i class="fa-solid fa-plus me-1"></i> Tambah Produk Baru', ['create'], ['class' => 'btn btn-warning fw-bold rounded-pill px-4 shadow-sm']) ?>
    </div>

    <?php if ($profile->status_verifikasi != 1): ?>
    <div class="alert alert-warning border-0 d-flex align-items-center mb-4" role="alert">
        <i class="fa-solid fa-triangle-exclamation fa-2x text-warning me-3"></i>
        <div>
            <strong>Perhatian:</strong> Profil toko Anda belum melewati proses Verifikasi Administratif oleh DINKOP.
            Anda tetap dapat mengunggah produk, namun produk belum dapat dilihat oleh publik (Status Draf) hingga toko Anda diverifikasi.
        </div>
    </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-body p-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'name',
                        'label' => 'Nama & Kategori Produk',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $cat = $model->category ? $model->category->name : 'Tanpa Kategori';
                            return "<div class='fw-bold text-dark'>{$model->name}</div><small class='text-muted'><i class='fa-solid fa-tag me-1'></i>{$cat}</small>";
                        }
                    ],
                    [
                        'attribute' => 'price',
                        'label' => 'Harga / Satuan',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $price = number_format($model->price, 0, ',', '.');
                            $unit = $model->unit ? "/ {$model->unit}" : '';
                            return "<div class='fw-bold text-success'>Rp {$price}</div><small class='text-muted'>{$unit}</small>";
                        }
                    ],
                    [
                        'attribute' => 'stock',
                        'label' => 'Stok',
                        'value' => function ($model) {
                            return $model->stock . ' Item';
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status Aktif',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->status == 1) {
                                return '<span class="badge bg-success bg-opacity-10 text-success rounded-pill"><i class="fa-solid fa-eye me-1"></i> Publik</span>';
                            }
                            return '<span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill"><i class="fa-solid fa-eye-slash me-1"></i> Draf Pribadi</span>';
                        }
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'header' => 'Aksi',
                        'template' => '<div class="btn-group">{update} {delete}</div>',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<i class="fa-solid fa-pen"></i> Edit', $url, [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'title' => 'Ubah Data',
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="fa-regular fa-trash-alt"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'title' => 'Hapus Produk',
                                    'data' => [
                                        'confirm' => 'Apakah Anda yakin ingin menghapus produk ini dari etalase selamanya?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
