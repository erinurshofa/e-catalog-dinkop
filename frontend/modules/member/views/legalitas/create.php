<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UmkmLegalitas */
/* @var $form yii\bootstrap5\ActiveForm */

$this->title = 'Unggah Dokumen Legalitas';
?>
<div class="legalitas-create">

    <div class="mb-4">
        <?= Html::a('<i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Dokumen', ['index'], ['class' => 'text-muted text-decoration-none fw-bold']) ?>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-transparent py-4 px-4 border-bottom-0">
                    <h4 class="fw-bold mb-1"><i class="fa-solid fa-cloud-arrow-up text-info me-2"></i> <?= Html::encode($this->title) ?></h4>
                    <p class="text-muted mb-0">Lampirkan file fisik izin usaha atau pendaftaran merek Anda di sini untuk divalidasi oleh Tim DINKOP Semarang.</p>
                </div>
                
                <div class="card-body p-4 pt-0">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                    
                    <div class="alert alert-secondary border-0 text-muted small d-flex align-items-center mb-4 rounded-3 shadow-none">
                        <i class="fa-solid fa-circle-exclamation fs-4 me-3 text-info"></i>
                        <div>Pastikan dokumen yang diunggah berupa scan asli / dokumen digital berkualitas baik. Format file yang didukung: <b>JPG, PNG, atau PDF</b>. Ukuran maksimal: <b>3 MB</b>.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $form->field($model, 'jenis_dokumen')->dropDownList([
                                'NIB (Nomor Induk Berusaha)' => 'NIB (Nomor Induk Berusaha)',
                                'NPWP Usaha' => 'NPWP Usaha',
                                'Sertifikat Halal' => 'Sertifikat Halal MUI/BPJPH',
                                'PIRT / SPP-IRT' => 'Izin PIRT / SPP-IRT',
                                'Izin BPOM' => 'Izin Edar BPOM',
                                'HAKI / Merek' => 'Sertifikat HAKI / Merek',
                                'Lainnya' => 'Dokumen Lainnya'
                            ], ['prompt' => 'Pilih Jenis Legalitas...'])->label('Jenis Dokumen yang Diunggah') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $form->field($model, 'nomor_dokumen')->textInput(['maxlength' => true, 'placeholder' => 'Ketik nomor surat/dokumen di sini...'])->label('Nomor Registrasi Dokumen (ID)') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $form->field($model, 'tanggal_terbit')->textInput(['type' => 'date'])->label('Tanggal Dokumen Diterbitkan (Opsional)') ?>
                        </div>
                        <div class="col-md-6 mb-4">
                            <?= $form->field($model, 'tanggal_kedaluwarsa')->textInput(['type' => 'date'])->label('Masa Berlaku Berakhir (Opsional)') ?>
                        </div>
                    </div>

                    <div class="mb-4 bg-light p-4 rounded-4 border border-dashed border-2 text-center" style="border-color: #dee2e6 !important;">
                        <i class="fa-solid fa-file-arrow-up fa-3x text-muted mb-3"></i>
                        <?= $form->field($model, 'file_upload', [
                            'options' => ['class' => 'mb-0']
                        ])->fileInput(['class' => 'form-control'])->label('<span class="fw-bold d-block mb-2">Pilih file PDF atau Gambar dari perangkat Anda</span>') ?>
                    </div>

                    <div class="form-group text-end pt-3 border-top mt-2">
                        <?= Html::a('Batal', ['index'], ['class' => 'btn btn-light rounded-pill px-4 me-2 fw-bold text-dark']) ?>
                        <?= Html::submitButton('<i class="fa-solid fa-paper-plane me-2"></i> Kirim untuk Divalidasi', ['class' => 'btn btn-info rounded-pill px-4 fw-bold shadow-sm text-white']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
