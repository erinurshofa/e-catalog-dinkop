<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Categories $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="categories-form">

    <div class="card admin-card border-0 shadow-sm" style="border-radius: 1rem;">
        <div class="card-body p-4">
            <?php $form = ActiveForm::begin(); ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control form-control-lg']) ?>
                </div>
                <div class="col-md-6 mb-3">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'form-control form-control-lg']) ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <?= $form->field($model, 'type')->dropDownList([
                        'Product' => 'Product',
                        'Service' => 'Service',
                        'Other' => 'Other'
                    ], ['prompt' => 'Pilih Tipe...', 'class' => 'form-select form-select-lg']) ?>
                </div>
            </div>

            <div class="form-group mt-4 pt-3 border-top text-end">
                <?= Html::a('Batal', ['index'], ['class' => 'btn btn-light rounded-pill px-4 me-2']) ?>
                <?= Html::submitButton('<i class="fa-solid fa-save me-1"></i> Simpan Kategori', ['class' => 'btn btn-primary rounded-pill px-4 fw-bold shadow-sm']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
