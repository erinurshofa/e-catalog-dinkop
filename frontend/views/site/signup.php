<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Pendaftaran UMKM - SemarangpreneurUP';
?>
<div class="site-signup py-5" style="background-color: var(--bg-light);">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Bergabung Bersama <span class="text-warning">Semarang</span><span class="text-danger">preneurUP</span></h2>
                    <p class="text-muted">Akses jutaan pelanggan potensial dan kembangkan usaha mikro Anda ke level selanjutnya, wujudkan kemandirian ekonomi.</p>
                </div>

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-5 d-none d-md-block bg-warning bg-opacity-10 position-relative p-5 d-flex flex-column justify-content-center" style="background-image: url('https://semarangkota.go.id/layout/images/tugu-muda.png'); background-size: cover; background-blend-mode: overlay;">
                            <div class="position-relative z-1 text-dark">
                                <h3 class="fw-bold mb-4">Kenapa Bergabung?</h3>
                                <ul class="list-unstyled">
                                    <li class="mb-3"><i class="fa-solid fa-check-circle text-success me-2"></i> Akses pasar lebih luas</li>
                                    <li class="mb-3"><i class="fa-solid fa-check-circle text-success me-2"></i> Terintegrasi dengan program DINKOP</li>
                                    <li class="mb-3"><i class="fa-solid fa-check-circle text-success me-2"></i> Tingkatkan kredibilitas usaha</li>
                                    <li><i class="fa-solid fa-check-circle text-success me-2"></i> 100% Gratis selamanya</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-7 p-4 p-lg-5 bg-white">
                            
                            <h4 class="fw-bold mb-4 border-bottom pb-2">Informasi Pendaftaran</h4>

                            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <?= $form->field($model, 'namaPemilik')->textInput(['placeholder' => 'Sesuai KTP'])->label('Nama Lengkap Pemilik', ['class' => 'fw-semibold text-dark']) ?>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <?= $form->field($model, 'namaUsaha')->textInput(['placeholder' => 'Contoh: Kriya Jati Sejahtera'])->label('Nama Usaha Katrolog', ['class' => 'fw-semibold text-dark']) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'nomorWhatsapp')->textInput(['placeholder' => '08123456789'])->label('Nomor WhatsApp', ['class' => 'fw-semibold text-dark']) ?>
                                </div>
                            </div>
                            
                            <hr class="my-4 text-muted">
                            <h5 class="fw-bold mb-3 fs-6">Informasi Akun (Login)</h5>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'emailanda@gmail.com'])->label('Alamat Email Valid', ['class' => 'fw-semibold text-dark']) ?>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <?= $form->field($model, 'username')->textInput(['placeholder' => 'Buat username unik'])->label('Username', ['class' => 'fw-semibold text-dark']) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Minimal 8 karakter'])->label('Kata Sandi', ['class' => 'fw-semibold text-dark']) ?>
                                </div>
                            </div>

                            <div class="form-group d-grid mb-3">
                                <?= Html::submitButton('Daftarkan Usaha Saya <i class="fa-solid fa-arrow-right ms-2"></i>', ['class' => 'btn btn-warning btn-lg fw-bold rounded-pill text-dark shadow-sm', 'name' => 'signup-button']) ?>
                            </div>
                            
                            <div class="text-center mt-4">
                                <p class="text-muted mb-0">Sudah memiliki akun UMKM? <a href="<?= \yii\helpers\Url::to(['site/login']) ?>" class="text-danger fw-bold text-decoration-none">Masuk di sini</a></p>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
