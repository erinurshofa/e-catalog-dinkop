<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Categories;

/* @var $this yii\web\View */
/* @var $model common\models\Products */
/* @var $form yii\bootstrap5\ActiveForm */

$this->title = $model->isNewRecord ? 'Tambah Produk Baru' : 'Ubah Produk: ' . $model->name;
?>
<div class="product-form">
    
    <div class="mb-4">
        <?= Html::a('<i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Katalog', ['index'], ['class' => 'text-muted text-decoration-none fw-bold']) ?>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
            <h4 class="fw-bold"><i class="fa-solid fa-box-open me-2 text-warning"></i> <?= Html::encode($this->title) ?></h4>
        </div>
        
        <div class="card-body p-4">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <div class="row">
                <div class="col-md-8">
                    <h6 class="text-warning fw-bold mb-3 border-bottom pb-2">Informasi Produk Terperinci</h6>
                    
                    <div class="mb-3">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: Bandeng Presto Juwana Super Lembut'])->label('Nama Produk Jualan') ?>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <?= $form->field($model, 'category_id')->dropDownList(
                                ArrayHelper::map(Categories::find()->all(), 'id', 'name'),
                                ['prompt' => 'Pilih Sektor Kategori...']
                            )->label('Kategori Barang') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'stock')->textInput(['type' => 'number', 'min' => 0])->label('Jumlah Stok Tersedia') ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'description')->textarea(['rows' => 5, 'placeholder' => 'Ceritakan keunggulan, bahan pokok, dan saran penyajian dari produk ini agar pelanggan tertarik...'])->label('Deskripsi Memikat') ?>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="bg-light p-3 p-md-4 rounded-4 h-100">
                        <h6 class="text-dark fw-bold mb-3 border-bottom pb-2">Harga & Varian</h6>
                        
                        <div class="mb-3">
                            <?= $form->field($model, 'price', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-text bg-white">Rp</span>{input}</div>',
                            ])->textInput(['type' => 'number', 'min' => 0])->label('Harga Jual Normal') ?>
                        </div>

                        <div class="mb-4">
                            <?= $form->field($model, 'unit')->textInput(['maxlength' => true, 'placeholder' => 'Pcs / Kg / Dus / Box'])->label('Satuan Unit') ?>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="mb-3">
                            <h6 class="text-dark fw-bold mb-3 pb-2"><i class="fa-regular fa-images text-primary me-2"></i> Foto Produk</h6>
                            <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => 'form-control'])->label(false) ?>
                            <div class="form-text mt-2"><i class="fa-solid fa-info-circle me-1"></i> Unggah hingga 5 foto (Format: JPG, PNG, WebP). Maksimal 2MB per foto.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group text-end pt-4 mt-2 border-top">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa-solid fa-cloud-arrow-up me-2"></i> Unggah Produk' : '<i class="fa-solid fa-save me-2"></i> Simpan Modifikasi', ['class' => 'btn btn-warning btn-lg rounded-pill px-5 fw-bold shadow-sm']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
