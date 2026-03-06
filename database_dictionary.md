# 📚 Database Data Dictionary

Dokumen ini merupakan panduan dan kamus data (*Data Dictionary*) untuk struktur basis data aplikasi **e-Katalog UMKM Dinkop Semarang**.

---

## 1. Tabel `user`
Tabel inti yang diciptakan oleh kerangka kerja *Yii2 Advanced* untuk mengelola autentikasi dan peran akses dasar.

| Kolom | Tipe Data | Keterangan / Kamus Nilai |
|---|---|---|
| `id` | INT (PK) | *Primary Key* User ID |
| `username` | VARCHAR | Nama pengguna unik (digunakan untuk *login*) |
| `auth_key` | VARCHAR | Kunci rahasia untuk autentikasi *cookie/remember-me* |
| `password_hash` | VARCHAR | *Hash* bcrypt dari kata sandi |
| `password_reset_token`| VARCHAR | Token unik sementara untuk pengaturan ulang kata sandi |
| `email` | VARCHAR | Alamat surel kontak unik pengguna |
| `status` | SMALLINT | **Kamus Status Akun:**<br>🔹 `10` = **Active / Aktif** (Pengguna bisa _login_ dan menggunakan aplikasi)<br>🔹 `9` = **Inactive** (Akun belum diverifikasi via surel, default Yii2)<br>🔹 `0` = **Deleted / Nonaktif** (Akun ditangguhkan/dihapus secara sistem) |
| `created_at` | INT | Unix Timestamp batas pembuatan akun |
| `updated_at` | INT | Unix Timestamp batas pembaruan akun terakhir |

---

## 2. Tabel `umkm_profile`
Tabel turunan dari `user` yang menyimpan data identitas dan informasi detail bisnis/toko milik setiap pelaku usaha (UMKM).

| Kolom | Tipe Data | Keterangan / Kamus Nilai |
|---|---|---|
| `id` | INT (PK) | *Primary Key* ID Profil UMKM |
| `user_id` | INT (FK) | Berelasi ke `user.id`. Setiap UMKM terikat pada 1 Akun User. |
| `nama_pemilik` | VARCHAR | Nama lengkap asli dari pemilik usaha |
| `nik` | VARCHAR(16)| Nomor Induk Kependudukan (NIK) pemilik |
| `nama_usaha` | VARCHAR | Merk dagang / nama warung atau toko |
| `alamat_pemilik` | TEXT | Alamat asal / KTP pemilik |
| `alamat_usaha` | TEXT | Alamat lapak / domisili usaha berjalan |
| `no_whatsapp` | VARCHAR | Nomor telepon / WhatsApp yang valid (contoh: 08123...) |
| `omzet_usaha` | DECIMAL | Estimasi omzet kotor per bulan (dalam satuan Rupiah) |
| `kategori_id` | INT (FK) | ID Kategori (berelasi ke tabel `categories` jika diatur) |
| `latitude` | DECIMAL | Titik koordinat Lokasi (Lintang) dari Google Maps |
| `longitude` | DECIMAL | Titik koordinat Lokasi (Bujur) dari Google Maps |
| `nib` | VARCHAR | Nomor Induk Berusaha |
| `status_verifikasi`| TINYINT | **Kamus Verifikasi Kurator Dinkop:**<br>⏱️ `0` = **Pending / Menunggu Verifikasi** (Dasbor dikunci)<br>✅ `1` = **Disetujui / Terverifikasi Aktif** (Bisa *upload* produk)<br>❌ `2` = **Ditolak / Perlu Perbaikan** |
| `created_at` | INT | Unix Timestamp waktu pendaftaran profil |
| `updated_at` | INT | Unix Timestamp waktu edit profil |

---

## 3. Tabel `products`
Tabel yang menampung daftar seluruh etalase katalog produk/jasa yang dijual oleh UMKM.

| Kolom | Tipe Data | Keterangan / Kamus Nilai |
|---|---|---|
| `id` | INT (PK) | *Primary Key* ID Produk |
| `umkm_profile_id` | INT (FK) | Pemilik produk (berelasi ke `umkm_profile.id`) |
| `category_id` | INT (FK) | Mengelompokkan produk (berelasi ke `categories.id`) |
| `name` | VARCHAR | Nama judul produk (contoh: "Keripik Singkong Balado") |
| `slug` | VARCHAR | Teks pendek unik ramah-URL (contoh: `keripik-singkong-balado-1639`) |
| `description` | TEXT | Penjelasan lengkap mengenai bahan, berat, atau spesifikasi |
| `price` | DECIMAL | Harga jual produk dalam format Rupiah |
| `stock` | INT | Jumlah perputaran stok. Kosongkan (0) jika tipe *Pre-Order* |
| `unit` | VARCHAR | Satuan penjualan (contoh: *Pcs, Gram, Box, Porsi*) |
| `is_featured` | TINYINT | **Kamus Produk Unggulan (Sorotan):**<br>⚪ `0` = **Reguler** (Tampil biasa)<br>⭐ `1` = **Featured / Unggulan** (Dipromosikan khusus oleh Admin di halaman awal) |
| `status` | TINYINT | **Kamus Moderasi Etalase:**<br>⏱️ `0` = **Draft / Menunggu Review** (Belum tayang publik)<br>✅ `1` = **Active / Terbit Publik** (Tampil di Katalog Umum)<br>❌ `2` = **Rejected / Ditolak** (Melanggar aturan katalog) |
| `view_count` | INT | Menghitung statistik klik lihat profil/produk oleh masyarakat |
| `created_at` | INT | Waktu _upload_ pertama |
| `updated_at` | INT | Waktu pengeditan gambar/harga terakhir |

---

## 4. Tabel `categories`
Tabel *Master Data* untuk menampung klasifikasi kategori produk/jasa yang hanya bisa ditambah/dihapus oleh Admin DINKOP.

| Kolom | Tipe Data | Keterangan / Kamus Nilai |
|---|---|---|
| `id` | INT (PK) | *Primary Key* ID Kategori |
| `parent_id` | INT | *Self-referencing FK* (Jika ingin ada sub-kategori, default *null*) |
| `name` | VARCHAR | Nama bersih kategori (contoh: "Kuliner", "Kriya") |
| `slug` | VARCHAR | Format *URL-friendly* (contoh: `kriya`) |
| `type` | ENUM | **Kamus Tipe Bisnis:**<br>📦 `Product` = Barang Fisik<br>🛠️ `Service` = Jasa<br>🌐 `Other` = Lain-lain/Campuran |

---

## 5. Tabel `product_image`
Tabel relasi (banyak ke satu) untuk menyimpan dokumentasi gambar/foto per produk (mendukung \> 1 foto).

| Kolom | Tipe Data | Keterangan / Kamus Nilai |
|---|---|---|
| `id` | INT (PK) | *Primary Key* ID Foto Produk |
| `product_id` | INT (FK) | Berelasi ke `products.id` |
| `image_path` | VARCHAR | Direktori/Path berkas foto ke peladen (contoh: `uploads/products/xyz.jpg`) |
| `is_primary` | TINYINT | **Kamus Urutan Tayang:**<br>👑 `1` = **Ya / Sampul** (Foto pertama yang jadi *thumbnail* muka)<br>⚪ `0` = **Bukan** (Hanya tampil di *slider* detail) |
| `created_at` | INT | Unix Timestamp tanggal _upload_ foto |

---

## 6. Tabel `umkm_legalitas`
Tabel tambahan untuk sistem modul pendataan/penyimpanan berkas hukum (PIRT, Halal, NIB PDF, dll) dari UMKM.

| Kolom | Tipe Data | Keterangan / Kamus Nilai |
|---|---|---|
| `id` | INT (PK) | *Primary Key* ID Surat/Dokumen |
| `umkm_profile_id` | INT (FK) | Berelasi ke `umkm_profile.id` pencipta/pengunggah |
| `jenis_dokumen` | VARCHAR | Jenis lisensi (contoh: "PIRT", "Sertifikat Halal", "Paten Merek") |
| `nomor_dokumen` | VARCHAR | Angka registrasi resmi (contoh: P-IRT 208332...) |
| `file_path` | VARCHAR | Lokasi berkas pindaian/PDF/Foto dokumen di _server_ |
| `status` | TINYINT | **Kamus Otentikasi Berkas (Oleh Dinkop):**<br>⏱️ `0` = **Sedang Diverifikasi**<br>✅ `1` = **Valid / Asli / Disetujui**<br>❌ `2` = **Ditolak / Tidak Sah** |
| `created_at` | INT | Unix Timestamp |
| `updated_at` | INT | Unix Timestamp |

---
*Dibuat secara profesional oleh asisten AI pengembangan e-Katalog Dinkop Semarang.*
