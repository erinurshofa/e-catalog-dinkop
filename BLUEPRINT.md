# Blueprint: E-Katalog Produk UMKM Kota Semarang (SemarangpreneurUP)

Dokumen ini berisi rancangan arsitektur, database, dan strategi performa untuk aplikasi E-Katalog Produk UMKM Dinas Koperasi dan Usaha Mikro (DINKOP) Kota Semarang.

## 1. Arsitektur Sistem Lengkap

Sistem dibangun dengan arsitektur modern berkinerja tinggi:

*   **Client Layer**: Web Browser (Desktop/Mobile) dengan **Bootstrap 5 + AlpineJS** untuk reaktivitas UI yang ringan.
*   **Web Server Layer**: **Nginx** (melakukan *gzip compression*, *static file caching*, dan *SSL termination*).
*   **Application Layer (Yii2)**:
    *   **Frontend App**: Aplikasi publik & dashboard UMKM.
    *   **Backend App**: Dasbor Admin DINKOP.
    *   **Console App**: Menjalankan *background jobs*/cron (seperti *image compression* di *background*, rekapitulasi statistik).
    *   **Service Layer**: Menangani *business logic* terpusat (contoh: `ProductService`, `UmkmVerificationService`).
*   **Data & Caching Layer**:
    *   **MySQL/MariaDB**: Master database dengan arsitektur Master-Slave (opsional untuk skala besar).
    *   **Redis**: Menyimpan hasil query berat (daftar unggulan, statistik), session management, dan antrean antrean proses (Queue).
*   **Storage Layer**: Local Storage / Object Storage yang menyimpan original dan thumbnail WebP.

---

## 2. Struktur Folder Framework (Yii2 Advanced + Service Layer)

Kita menggunakan ekstensi terhadap standar Yii2 Advanced:

```text
e-catalog-dinkop/
├── backend/               # Area Admin DINKOP
│   ├── modules/           # Modul: umkm, product, setting, report
├── common/             
│   ├── config/            # Konfigurasi DB, Redis, Parameters
│   ├── models/            # ActiveRecord Models Utama
│   └── services/          # [PENTING] Service/Business Logic Layer
├── console/               # Cron jobs & Yii2 Queue workers (ZMQ / Redis worker)
├── frontend/              # Web Publik & Area Member UMKM
│   ├── modules/           # Modul: catalog, member (dashboard UMKM)
└── vendor/                # Composer dependencies
```

---

## 3. Desain Database Lengkap (Optimized & Normalized)

Tabel dirancang dengan index yang agresif untuk performa `SELECT` yang tinggi.

### Tabel Utama:
1.  **`users`**: Tabel Autentikasi Utama (RBAC logic).
2.  **`umkm_profile`**: Data UMKM (Nama, NIK, Alamat, NIB, Latitude/Longitude, Omzet, Status). Terdapat index pada `nama_usaha` dan lokasi.
3.  **`umkm_documents`**: Soft copy dokumen legal (NIB, PIRT, Halal).
4.  **`categories`**: Kategori Produk & Kategori Usaha.
5.  **`products`**: Data detail produk. Terdapat `FULLTEXT INDEX` pada nama produk.
6.  **`product_images`**: Multi-gambar tiap produk (Main path & Thumb/WebP path).
7.  **`verification_logs`**: Menyimpan rekam jejak admin saat me-*reject* atau *approve* UMKM/Produk.

---

## 4. Entity Relationship Diagram (ERD) Flow

```text
[USERS] 1 ----- M [UMKM_PROFILE]
[USERS] 1 ----- M [VERIFICATION_LOGS] (Sebagai Admin)

[UMKM_PROFILE] 1 ----- M [PRODUCTS]
[UMKM_PROFILE] 1 ----- M [UMKM_DOCUMENTS]
[UMKM_PROFILE] 1 ----- M [VERIFICATION_LOGS] (Obyek yang diverifikasi)

[CATEGORIES] 1 ----- M [PRODUCTS] (Kategori Produk)
[CATEGORIES] 1 ----- M [UMKM_PROFILE] (Kategori Usaha)

[PRODUCTS] 1 ----- M [PRODUCT_IMAGES]
[PRODUCTS] 1 ----- M [VERIFICATION_LOGS] (Obyek yang diverifikasi)
```

---

## 5. Flow Bisnis (User Flow)

*   **Pendaftaran UMKM**: Register Akun -> Login -> Isi Profil Usaha Lengkap -> Upload Dokumen PIRT/NIB -> Status `Pending Verifikasi`.
*   **Verifikasi DINKOP**: Admin Buka Dashboard -> Filter `Status: Pending` -> Cek Dokumen -> Klik `Approve` atau `Reject` (dengan catatan alasan).
*   **Kelola Produk**: UMKM Terverifikasi -> Menu Produk -> Tambah Produk -> Upload Foto Asli -> Background Worker *compress* WebP -> Status Produk `Pending Review`.
*   **Pencarian Publik**: Buka Beranda -> Ketik 'Bandeng' -> Query Database menggunakan `MATCH() AGAINST()` Fulltext Search, dibantu Redis Cache -> Tampil Grid Responsive dalam waktu kurang dari 0.3 detik.

---

## 6. UI / UX & Design Style Guidelines

*   **Responsivitas**: Wajib *Mobile-First*, karena 80% pengunjung UMKM dari *smartphone*.
*   **Desain**: *Clean, Modern, Government Professional*.
*   **Brand Color**:
    *   Warna Primer: Kuning (`#FFC107` / Varian SemarPreneurUp)
    *   Warna Aksen: Merah (`#DC3545` atau merah khas ikonografi lokal)
    *   Background: Putih (`#FFFFFF`) dan Abu Soft (`#F8F9FA`) untuk *card product*.

---

## 7. Strategi Performa Tinggi (Skala Ratusan Ribu Data)

Sasaran utama adalah waktu *load* UI di bawah 1 detik dan *query constraint* < 0.3 detik.

1.  **MySQL Indexing**: Implementasi `FULLTEXT SEARCH` pada produk, bukan sekadar `LIKE '%search%'`. `Category_id` dan `status` wajib di-*index*.
2.  **Redis Page/Data Caching**:
    *   Data *slow changing* seperti daftar kategori dan produk "UMKM Terbaru di Beranda" akan disalin (caching) ke dalam string Redis dengan usia kedaluwarsa (TTL) tertentu.
    *   Sesi user dialihkan ke Redis agar tidak membebani file / hardisk *server*.
3.  **Image Compression Asynchronous**:
    *   Saat *upload*, gunakan `yii2-queue` + Redis Worker. Foto *user* tidak di*convert* '*on the fly*' agar UI tidak *freeze*. Proses jalan di belakang layar.
    *   Di frontend, gunakan `lazy loading` (`<img loading="lazy">`).

---

## 8. Persiapan Menuju Marketplace (Pemesanan)

*Blueprint* ini tidak menutup sistem. Saat sistem sudah stabil sebagai sarana promosi, aplikasi siap ditingkatkan dengan:
1.  **Modul Transaksi**: Penambahan tabel `orders`, `order_items`, `payments`, `shippings`.
2.  **API Gateway Integrasi**: Modul HTTP terpisah untuk *request* ke Xendit / Midtrans untuk *virtual account payment gateway*.
3.  **Logika Stock Atomic**: Penggunaan Redis *locking* dan MySQL *Transaction isolation level* untuk menghindari balapan/tabrakan '*stok barang*' saat ribuan *user* *checkout* produk populer di detik yang sama.
