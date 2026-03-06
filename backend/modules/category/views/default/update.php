<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Categories $model */

$this->title = 'Edit Kategori: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kategori Master', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="categories-update">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="mb-1 fw-bold text-dark"><i class="fa-solid fa-pen-to-square text-primary me-2"></i> Edit Kategori</h3>
            <p class="text-muted mb-0">Ubah detail Kategori Master.</p>
        </div>
        <div>
            <?= Html::a('<i class="fa-solid fa-arrow-left me-1"></i> Kembali', ['index'], ['class' => 'btn btn-outline-secondary rounded-pill px-4']) ?>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
