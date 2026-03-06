<?php

use common\models\Categories;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\CategoriesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kategori Master';
$this->params['breadcrumbs'][] = $this->title;

// Inject premium styling
$this->registerCss("
    .admin-card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
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
");
?>
<div class="categories-index">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="mb-1 fw-bold text-dark"><i class="fa-solid fa-tags text-primary me-2"></i> Kategori Produk Master</h3>
            <p class="text-muted mb-0">Kelola daftar kategori yang dapat dipilih oleh UMKM.</p>
        </div>
        <div>
            <?= Html::a('<i class="fa-solid fa-plus me-1"></i> Tambah Kategori', ['create'], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm fw-bold']) ?>
        </div>
    </div>

    <div class="card admin-card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => null, // simple ui for now
                    'layout' => "{items}\n<div class='p-3 border-top d-flex justify-content-between align-items-center'>{summary}\n{pager}</div>",
                    'tableOptions' => ['class' => 'table table-hover mb-0 w-100'],
                    'pager' => [
                        'class' => \yii\bootstrap5\LinkPager::class,
                        'options' => ['class' => 'pagination justify-content-end mb-0'],
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'name',
                            'label' => 'Nama Kategori',
                            'format' => 'raw',
                            'value' => function($model) {
                                return '<div class="fw-bold text-dark">' . Html::encode($model->name) . '</div>' . 
                                       '<div class="small text-muted">' . Html::encode($model->slug) . '</div>';
                            }
                        ],
                        'type',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Aksi',
                            'template' => '<div class="btn-group">{update} {delete}</div>',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa-solid fa-pen"></i> Edit', ['update', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-outline-primary',
                                    ]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa-solid fa-trash"></i> Hapus', ['delete', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'data' => [
                                            'confirm' => 'Yakin ingin menghapus kategori ini?',
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
