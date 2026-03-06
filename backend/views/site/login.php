<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Login Kurator';
$this->registerCss("
    .login-container {
        display: flex;
        min-height: 100vh;
        width: 100%;
        background-color: #ffffff;
    }
    
    /* Left Side: Brand & Hero */
    .login-hero {
        flex: 1;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 4rem;
        position: relative;
        overflow: hidden;
    }
    
    /* Decorative elements */
    .login-hero::before {
        content: '';
        position: absolute;
        top: -10%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,193,7,0.15) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }
    .login-hero::after {
        content: '';
        position: absolute;
        bottom: -15%;
        left: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    .brand-logo {
        font-size: 2rem;
        font-weight: 900;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: white;
        z-index: 10;
        margin-bottom: 2rem;
    }
    .brand-logo i { color: #ffc107; margin-right: 0.75rem; font-size: 2.2rem; }
    .brand-text-semar { color: white; }
    .brand-text-preneur { color: #ffc107; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }

    .hero-content {
        z-index: 10;
        max-width: 500px;
    }
    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .hero-subtitle {
        font-size: 1.1rem;
        font-weight: 300;
        opacity: 0.9;
        line-height: 1.6;
    }
    
    .hero-footer {
        z-index: 10;
        font-size: 0.85rem;
        opacity: 0.7;
    }

    /* Right Side: Form */
    .login-form-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        background-color: #fafafa;
    }
    .login-box {
        width: 100%;
        max-width: 450px;
        background: white;
        padding: 3rem;
        border-radius: 1.5rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.02);
    }
    
    .form-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 0.5rem;
    }
    .form-subtitle {
        color: #6b7280;
        margin-bottom: 2rem;
    }

    .form-control {
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.85rem 1.25rem;
        font-size: 1rem;
        color: #374151;
        transition: all 0.2s;
    }
    .form-control:focus {
        background-color: #ffffff;
        border-color: #2a5298;
        box-shadow: 0 0 0 4px rgba(42, 82, 152, 0.1);
    }
    
    .input-group-text.password-toggle {
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-left: none;
        border-radius: 0 0.75rem 0.75rem 0;
        cursor: pointer;
        color: #6b7280;
        transition: all 0.2s;
    }
    .input-group-text.password-toggle:hover {
        color: #1e3c72;
    }
    .form-control.password-input {
        border-right: none;
        border-radius: 0.75rem 0 0 0.75rem;
    }
    .form-control.password-input:focus {
        box-shadow: none; /* Let the JS or outer wrapper handle shadow if needed for seamless look, or leave it for now */
    }
    
    .btn-login {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border: none;
        border-radius: 0.75rem;
        padding: 0.85rem 1.5rem;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        width: 100%;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(30, 60, 114, 0.2);
    }
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(30, 60, 114, 0.3);
        color: white;
    }

    /* Floating Labels Styling (Optional refinement for standard Yii fields) */
    .field-loginform-username, .field-loginform-password {
        margin-bottom: 1.5rem;
    }
    .has-error .form-control {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
    .help-block-error {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .login-hero {
            display: none; /* Hide hero on small screens */
        }
        .login-box {
            padding: 2rem;
            box-shadow: none;
            background: transparent;
        }
        .login-form-wrapper {
            background-color: #ffffff;
            align-items: flex-start;
            padding-top: 10vh;
        }
    }
");
?>
<div class="login-container">
    
    <!-- Left Hero Section -->
    <div class="login-hero">
        <a href="<?= Url::to('@web/../../frontend/web/index.php') ?>" class="brand-logo" target="_blank">
            <i class="fa-solid fa-building-columns"></i>
            <div>
                <span class="brand-text-semar">Admin</span><span class="brand-text-preneur">Dinkop</span>
            </div>
        </a>
        
        <div class="hero-content">
            <h1 class="hero-title">Pusat Kurasi &<br>Manajemen Data UMKM</h1>
            <p class="hero-subtitle">
                Portal eksklusif bagi tim kurator Dinas Koperasi dan Usaha Mikro Kota Semarang untuk meninjau, menyetujui, dan mengelola pendaftaran UMKM serta produk katalog unggulan secara efisien.
            </p>
        </div>
        
        <div class="hero-footer">
            &copy; <?= date('Y') ?> Dinas Koperasi dan Usaha Mikro Kota Semarang.<br>Diselenggarakan oleh Pemerintah Kota Semarang.
        </div>
    </div>
    
    <!-- Right Form Section -->
    <div class="login-form-wrapper">
        <div class="login-box">
            
            <div class="d-lg-none brand-logo mb-4" style="color:#1e3c72;">
                <i class="fa-solid fa-building-columns" style="color:#1e3c72;"></i>
                <div>
                    <span class="brand-text-semar">Admin</span><span class="brand-text-preneur" style="color:#ffc107;">Dinkop</span>
                </div>
            </div>

            <h2 class="form-title">Selamat Datang Kembalí</h2>
            <p class="form-subtitle">Silakan masukkan kredensial kurator Anda.</p>
            
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'mt-4']
            ]); ?>

            <?= $form->field($model, 'username', [
                'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Nama Pengguna (Username)']
            ])->label(false) ?>

            <div class="input-group mb-4">
                <?= Html::activePasswordInput($model, 'password', [
                    'class' => 'form-control password-input', 
                    'placeholder' => 'Kata Sandi',
                    'id' => 'loginform-password'
                ]) ?>
                <span class="input-group-text password-toggle" id="togglePassword">
                    <i class="fa-solid fa-eye" id="toggleIcon"></i>
                </span>
            </div>
            <?= Html::error($model, 'password', ['class' => 'help-block-error']) ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <?= $form->field($model, 'rememberMe', [
                    'options' => ['class' => 'form-check mb-0']
                ])->checkbox(['class' => 'form-check-input'])->label('Ingat Saya', ['class' => 'form-check-label text-muted small']) ?>
                
                <a href="#" class="text-primary small text-decoration-none fw-medium">Lupa sandi?</a>
            </div>

            <div class="form-group mb-0">
                <?= Html::submitButton('Masuk ke Dasbor <i class="fa-solid fa-arrow-right ms-2"></i>', ['class' => 'btn-login', 'name' => 'login-button']) ?>
            </div>
            
            <?php ActiveForm::end(); ?>
            
            <div class="mt-5 text-center text-muted small d-lg-none">
                &copy; <?= date('Y') ?> Dinkop Kota Semarang
            </div>

        </div>
    </div>
    
</div>

<?php
$this->registerJs("
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        const passwordInput = document.getElementById('loginform-password');
        const icon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
");
?>
