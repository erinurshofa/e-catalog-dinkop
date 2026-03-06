<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Categories $model */

$this->title = 'Buat Kategori Baru';
$this->params['breadcrumbs'][] = ['label' => 'Kategori Master', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="mb-1 fw-bold text-dark"><i class="fa-solid fa-plus-circle text-success me-2"></i> Tambah Kategori</h3>
            <p class="text-muted mb-0">Masukkan detail kategori produk/layanan baru untuk referensi UMKM.</p>
        </div>
        <div>
            <?= Html::a('<i class="fa-solid fa-arrow-left me-1"></i> Kembali', ['index'], ['class' => 'btn btn-outline-secondary rounded-pill px-4']) ?>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
