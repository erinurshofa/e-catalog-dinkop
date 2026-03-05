<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Categories;

/* @var $this yii\web\View */
/* @var $model common\models\UmkmProfile */
/* @var $form yii\bootstrap5\ActiveForm */

$this->title = 'Lengkapi Profil Toko';

// Panggil Leaflet Asset secra spesifik untuk view ini
$this->registerCssFile('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
$this->registerCssFile('https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css');
$this->registerJsFile('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js', ['position' => \yii\web\View::POS_HEAD]);
?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                <h4 class="fw-bold"><i class="fa-solid fa-store me-2 text-warning"></i> <?= Html::encode($this->title) ?></h4>
                <p class="text-muted">Isi kelengkapan data administratif usaha Anda sesuai NIB dan KTP.</p>
            </div>
            
            <div class="card-body p-4">
                
                <?php $form = ActiveForm::begin(['id' => 'profile-form']); ?>
                
                <h6 class="text-warning fw-bold mb-3 border-bottom pb-2">Informasi Kepemilikan</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <?= $form->field($model, 'nama_pemilik')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?= $form->field($model, 'nik')->textInput(['maxlength' => true, 'placeholder' => '16 Digit NIK KTP Pengelola']) ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?= $form->field($model, 'no_whatsapp')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-12 mb-4">
                        <?= $form->field($model, 'alamat_pemilik')->textarea(['rows' => 3]) ?>
                    </div>
                </div>

                <h6 class="text-warning fw-bold mb-3 border-bottom pb-2">Identitas Usaha</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <?= $form->field($model, 'nama_usaha')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?= $form->field($model, 'nib')->textInput(['maxlength' => true, 'placeholder' => 'Nomor Induk Berusaha (Jika Ada)']) ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?= $form->field($model, 'kategori_usaha_id')->dropDownList(
                            ArrayHelper::map(Categories::find()->all(), 'id', 'name'),
                            ['prompt' => 'Pilih Sektor Usaha Anda...']
                        )->label('Kategori Usaha') ?>
                    </div>
                    <div class="col-md-12 mb-4">
                        <?= $form->field($model, 'deskripsi_usaha')->textarea(['rows' => 4, 'placeholder' => 'Ceritakan secara singkat tentang usaha dan produk unggulan yang Anda tawarkan kepada pelanggan.']) ?>
                    </div>
                    <div class="col-md-12 mb-4">
                        <?= $form->field($model, 'alamat_usaha')->textarea(['rows' => 3, 'placeholder' => 'Alamat Lengkap Toko / Lokasi Produksi']) ?>
                    </div>
                </div>

                <h6 class="text-warning fw-bold mb-3 border-bottom pb-2 mt-2">Detail Lokasi Peta (Koordinat)</h6>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Tautkan dari Link Google Maps (Opsional)</label>
                        <?= $form->field($model, 'link_gmaps', [
                            'template' => '<div class="input-group"><span class="input-group-text bg-white"><i class="fa-brands fa-google text-danger"></i></span>{input}<button class="btn btn-outline-secondary fw-bold" type="button" id="btn-extract-gmaps" title="Ambil titik Lat-Long otomatis dari link di atas">Ambil Titik Peta</button></div>{error}',
                        ])->textInput(['id' => 'gmaps-link', 'placeholder' => 'Contoh URL: https://www.google.com/maps/place/.../@-6.99,110.42,15z'])->label(false) ?>
                        <small class="text-muted d-block mt-1 text-justify">Tempelkan URL Google Maps panjang Anda di atas. Anda dapat menyimpan tautan tersebut saja agar pengunjung men-klik di katalog Anda nantinya, atau tekan tombol peringkas di sebelah kanan untuk langsung menempatkan 'Panduan Penanda' ke dalam peta di bawah!</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'id' => 'input-lat', 'placeholder' => '-6.9932000']) ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'id' => 'input-lng', 'placeholder' => '110.4203000']) ?>
                    </div>
                    
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-bold">Tentukan Titik Akurat pada Peta</label>
                        <div id="map" style="height: 300px; width: 100%; border-radius: 10px; z-index: 1;" class="border shadow-sm"></div>
                        <small class="text-muted mt-2 d-block"><i class="fa-solid fa-info-circle me-1"></i> Klik di mana saja pada peta atau <b>geser marker biru</b> untuk memindahkan panduan lokasi toko Anda secara manual.</small>
                    </div>
                </div>

                <h6 class="text-warning fw-bold mb-3 border-bottom pb-2 mt-2">Data Permodalan (Opsional)</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <?= $form->field($model, 'modal_awal', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-text">Rp</span>{input}</div>',
                            ])->textInput(['type' => 'number']) ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <?= $form->field($model, 'aset_usaha', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-text">Rp</span>{input}</div>',
                            ])->textInput(['type' => 'number']) ?>
                    </div>
                    <div class="col-md-4 mb-5">
                        <?= $form->field($model, 'omzet_usaha', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-text">Rp</span>{input}</div>',
                            ])->textInput(['type' => 'number']) ?>
                    </div>
                </div>

                <div class="form-group text-end pt-3 border-top">
                    <?= Html::a('Batal', ['index'], ['class' => 'btn btn-light rounded-pill px-4 me-2 fw-bold text-dark']) ?>
                    <?= Html::submitButton('<i class="fa-solid fa-save me-2"></i> Simpan Perubahan Profil', ['class' => 'btn btn-warning rounded-pill px-4 fw-bold shadow-sm']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$(document).ready(function() {
    var defaultLat = -6.9932; // Pusat Semarang Default
    var defaultLng = 110.4203;
    
    // Gunakan value dari input, jika kosong pakai default
    var currentLat = $('#input-lat').val() ? parseFloat($('#input-lat').val()) : defaultLat;
    var currentLng = $('#input-lng').val() ? parseFloat($('#input-lng').val()) : defaultLng;

    var map = L.map('map').setView([currentLat, currentLng], 14);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 19
    }).addTo(map);

    var marker = L.marker([currentLat, currentLng], {draggable: true}).addTo(map);

    // Tambahkan Fitur Pencarian Alamat (Geocoder)
    L.Control.geocoder({
        defaultMarkGeocode: false,
        placeholder: "Cari Alamat Toko Anda..."
    })
    .on('markgeocode', function(e) {
        var bbox = e.geocode.bbox;
        var poly = L.polygon([
            bbox.getSouthEast(),
            bbox.getNorthEast(),
            bbox.getNorthWest(),
            bbox.getSouthWest()
        ]);
        map.fitBounds(poly.getBounds());
        
        var latlng = e.geocode.center;
        marker.setLatLng(latlng);
        updateInputs(latlng.lat, latlng.lng);
    })
    .addTo(map);

    // Fungsi update kolom text
    function updateInputs(lat, lng) {
        $('#input-lat').val(lat.toFixed(7));
        $('#input-lng').val(lng.toFixed(7));
    }

    // Assign default pertama kali kalau kosong
    if(!$('#input-lat').val() || !$('#input-lng').val()) {
        updateInputs(currentLat, currentLng);
    }

    // Event saat pin diseret (Drag)
    marker.on('dragend', function (e) {
        var latlng = marker.getLatLng();
        updateInputs(latlng.lat, latlng.lng);
        map.panTo(latlng);
    });

    // Event saat map diklik bebas
    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updateInputs(e.latlng.lat, e.latlng.lng);
        map.panTo(e.latlng);
    });

    // Sync input manual dari keyboard ke Peta
    $('#input-lat, #input-lng').on('change', function() {
        var lat = parseFloat($('#input-lat').val());
        var lng = parseFloat($('#input-lng').val());
        if(!isNaN(lat) && !isNaN(lng)) {
            var newLatLng = new L.LatLng(lat, lng);
            marker.setLatLng(newLatLng);
            map.panTo(newLatLng);
        }
    });

    // Fitur parsing link Google Maps otomatis
    $('#btn-extract-gmaps').on('click', function() {
        var link = $('#gmaps-link').val();
        if(!link) {
            alert('Silakan tempel URL Google Maps terlebih dahulu pada kolom teks!');
            return;
        }
        
        // Coba baca parameter koordinat @lat,lng,zoomz dari Link
        var regex = /@(-?\d+\.\d+),(-?\d+\.\d+)/;
        var match = link.match(regex);
        
        if(match && match.length >= 3) {
            var lat = parseFloat(match[1]);
            var lng = parseFloat(match[2]);
            
            var newLatLng = new L.LatLng(lat, lng);
            marker.setLatLng(newLatLng);
            map.setZoom(16);
            map.panTo(newLatLng);
            updateInputs(lat, lng);
        } else {
            alert("Sistem tidak dapat menebak koordinat dari Tautan yang Anda berikan. Pastikan Anda menyalin alamat URL panjang (Dari Web Komputer) yang menampilkan pola koordinat '@...'.");
        }
    });

    // Prevent Leaflet Map visual glitch on inactive tabs/collapse
    setTimeout(function() {
        map.invalidateSize();
    }, 500);
});
JS;
$this->registerJs($js);
?>
