<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Masuk - SemarangpreneurUP';
?>
<div class="site-login py-5" style="background-color: var(--bg-light); min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="p-4 p-lg-5 bg-white">
                        
                        <div class="text-center mb-4">
                            <div class="custom-brand-logo mb-3 d-inline-flex mx-auto" style="transform: rotate(-3deg); transform-origin: center;">
                                <span class="text-semar" style="font-size: 1.8rem;">Semar</span>
                                <span class="text-preneur" style="font-size: 2.2rem; margin-top: 5px;">PreneurUP</span>
                            </div>
                            <h4 class="fw-bold text-dark">Selamat Datang Kembali</h4>
                            <p class="text-muted small">Masuk ke Dasbor Pengelola UMKM Anda</p>
                        </div>

                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                            <div class="mb-3">
                                <?= $form->field($model, 'username', [
                                    'inputOptions' => ['class' => 'form-control form-control-lg bg-light border-0', 'placeholder' => 'Username Anda']
                                ])->textInput(['autofocus' => true])->label('Username', ['class' => 'fw-semibold text-dark mb-1']) ?>
                            </div>

                            <div class="mb-3">
                                <?= $form->field($model, 'password', [
                                    'inputOptions' => ['class' => 'form-control form-control-lg bg-light border-0', 'placeholder' => '••••••••']
                                ])->passwordInput()->label('Kata Sandi', ['class' => 'fw-semibold text-dark mb-1']) ?>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'mb-0']])->checkbox([
                                    'template' => "<div class=\"form-check\">{input} {label}</div>\n{error}",
                                ])->label('Ingat Saya', ['class' => 'form-check-label text-muted']) ?>
                                
                                <?= Html::a('Lupa Sandi?', ['site/request-password-reset'], ['class' => 'text-danger fw-semibold text-decoration-none small']) ?>
                            </div>

                            <div class="form-group d-grid">
                                <?= Html::submitButton('Masuk ke Dasbor <i class="fa-solid fa-sign-in-alt ms-2"></i>', ['class' => 'btn btn-warning btn-lg fw-bold rounded-pill text-dark shadow-sm', 'name' => 'login-button']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>
                        
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted mb-0 small">Belum mendaftarkan usaha Anda? <br>
                                <a href="<?= \yii\helpers\Url::to(['site/signup']) ?>" class="text-dark fw-bold text-decoration-none">Daftar Sekarang Gratis</a>
                            </p>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</div>
