# 🔄 Alur Sistem e-Katalog UMKM Dinkop Semarang

Dokumen ini menjelaskan alur kerja (*Business Flow*) utama dari aplikasi katalog dari sisi Pelaku UMKM, Admin DINKOP, dan Masyarakat Umum.

---

## 1. Alur Pendaftaran & Verifikasi UMKM (Onboarding)
Flow ini menjelaskan bagaimana seorang pelaku usaha mendaftar hingga akunnya disetujui.

```mermaid
sequenceDiagram
    participant U as Pelaku UMKM
    participant S as Sistem (Portal)
    participant A as Admin DINKOP

    U->>S: Mengisi Form Pendaftaran (Nama, WA, Email, Usaha)
    S-->>U: Akun Terbuat (Role: UMKM, Status Verifikasi: Pending/0)
    U->>S: Login ke Dasbor Member
    S-->>U: Menampilkan Dasbor (Menu 'Produk Saya' Terkunci 🔒)
    U->>S: Melengkapi Profil & Dokumen Legalitas (NIB, PIRT, dll)
    
    Note over A,S: Admin melakukan peninjauan harian
    A->>S: Login ke Dasbor Admin Dinkop
    S-->>A: Menampilkan Tabel 'Menunggu Verifikasi'
    A->>S: Validasi Data KTP, Alamat, dan Dokumen
    
    alt Jika Data Valid
        A->>S: Klik 'Setujui' (Approve)
        S-->>U: Status berubah (Disetujui/1). Menu Produk Terbuka! 🔓
    else Jika Data Tidak Lengkap/Palsu
        A->>S: Klik 'Tolak' (Reject)
        S-->>U: Status berubah (Ditolak/2). Wajib perbaikan data.
    end
```

---

## 2. Alur Unggah & Publikasi Produk
Flow ini menjelaskan tata cara UMKM menawarkan barang dagangannya hingga bisa dibeli masyarakat.

```mermaid
sequenceDiagram
    participant U as Pelaku UMKM (Terverifikasi)
    participant S as Sistem (Portal)
    participant A as Admin DINKOP
    participant P as Publik/Pembeli

    U->>S: Akses Menu 'Produk Saya' -> 'Tambah Produk'
    U->>S: Upload Foto asli, Isi Harga, Stok, dan Deskripsi
    S-->>U: Produk tersimpan (Status: Draft/Review/0)
    
    Note over A,S: Kurasi kualitas foto dan kewajaran harga
    A->>S: Buka menu 'Review Produk' di Bekend
    A->>S: Lakukan Kurasi Kelayakan Tayang
    
    alt Jika Lolos Kurasi
        A->>S: Klik 'Terbitkan' (Publish)
        S-->>P: Produk Tampil di e-Katalog Umum (Status: Aktif/1)
    else Jika Foto Buram / Harga Tidak Wajar
        A->>S: Klik 'Kembalikan/Tolak'
        S-->>U: Produk tetap disembunyikan. Wajib ganti foto/harga.
    end
```

---

## 3. Alur Etalase & Transaksi Masyarakat (Katalog Publik)
Flow ini mendeskripsikan aktivitas pengunjung secara umum saat mencari barang.

```mermaid
sequenceDiagram
    participant P as Publik/Pembeli
    participant S as e-Katalog (Web)
    participant WA as WhatsApp UMKM

    P->>S: Mengakses Halaman Utama E-Katalog
    S-->>P: Menampilkan Produk Unggulan & Terbaru
    P->>S: Mencari produk atau memilih Kategori (misal: "Kuliner")
    S-->>P: Menampilkan Grid Produk Kategori Terkait
    P->>S: Klik salah satu Kartu Produk
    S-->>P: Menampilkan Detail: Deskripsi, multi-foto, Harga, dan Profil Toko
    
    Note over P,WA: Tidak ada Payment Gateway. Transaksi langsung ke penjual.
    P->>S: Klik tombol "Beli via WhatsApp"
    S-->>P: Redirect ke Aplikasi WhatsApp
    P->>WA: Mengirim template pesan: "Halo, saya tertarik dengan produk (Nama Produk)..."
    WA-->>P: (UMKM merespon pesanan dan melanjutkan transaksi privat)
```

---

### Hak Akses / Otorisasi Berjenjang
1. **DINKOP (Admin)**: 
   - Memiliki kendali penuh menyetujui (`approve`) pengguna dan produk. 
   - Bisa mengatur *Master* Kategori Produk.
   - Bisa menyorot (*Featured*) produk-produk terbaik untuk diletakkan di halaman depan.
2. **UMKM (Member)**:
   - Terkunci haknya hingga diverifikasi Admin.
   - Setelah valid, bisa mengelola Etalase internal tokonya sendiri (CRUD Produk).
3. **Masyarakat Umum (Guest)**:
   - Hanya memiliki hak akses membacakatalog produk (Beranda, Daftar Kategori, Pencarian).
   - Diarahkan bertransaksi P2P (*Peer-to-Peer*) melalui sambungan WhatsApp.
