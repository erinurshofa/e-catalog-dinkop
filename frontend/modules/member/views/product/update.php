<?php

/* @var $this yii\web\View */
/* @var $model common\models\Products */

$this->title = 'Edit Produk: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Katalog Produk Saya', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="product-update">
    <?= $this->render('create', [
        'model' => $model,
    ]) ?>
</div>
