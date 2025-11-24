# SIM INVENTARIS KAMPUS (SIM-IV)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![DomPDF](https://img.shields.io/badge/PDF_Reporting-DomPDF-red?style=for-the-badge)

## 📖 Tentang Proyek

**SIM Inventaris Kampus** adalah aplikasi berbasis web yang dirancang untuk mengelola siklus hidup aset (*Asset Lifecycle*) di lingkungan universitas. Sistem ini menangani pencatatan aset dari hulu (Pengajuan/Akuisisi) hingga hilir (Pelaporan & Penghapusan).

Aplikasi ini membedakan secara tegas antara **Aset Tetap** (Laptop, Proyektor, Kendaraan) dengan **Barang Habis Pakai/BHP** (ATK, Obat, Bahan Praktik) menggunakan logika *Batch* dan *FIFO*.

---

## 🚀 Fitur Utama

### 1. 📊 Dashboard Eksekutif
* **Ringkasan Real-time:** Total nilai aset, jumlah peminjaman aktif, dan stok kritis.
* **Early Warning System:** Notifikasi tabel untuk barang yang akan kadaluarsa dan peminjam yang terlambat.

### 2. 🛍️ Akuisisi (Procurement)
* Manajemen usulan pengadaan barang dari User/Staff.
* Sistem persetujuan (Approval) bertingkat oleh Admin.
* Integrasi otomatis: Usulan yang disetujui dapat langsung diproses menjadi stok gudang.

### 3. 💻 Manajemen Aset Tetap (Fixed Assets)
* **Parent-Child Structure:** Memisahkan data induk (Nama Barang) dengan unit fisik (Kode Unik).
* Pelacakan status ketersediaan (Tersedia, Dipinjam, Rusak, Maintenance).
* Pencatatan lokasi (Ruangan) dan sumber dana.

### 4. 💊 Manajemen Barang Habis Pakai (Consumables)
* **Batch System:** Stok dicatat per batch kedatangan untuk melacak tanggal kadaluarsa (*Expiry Date*).
* **Kartu Stok Digital:** Riwayat transaksi masuk (Debit) dan keluar (Kredit) yang transparan.

### 5. 🔄 Sirkulasi & Transaksi
* **Peminjaman Aset:** Validasi otomatis (barang rusak/sedang dipinjam tidak bisa dipinjamkan).
* **Penggunaan BHP:** Pencatatan pengambilan stok untuk keperluan operasional.

### 6. 📄 Pelaporan (Reporting)
* Cetak laporan otomatis ke format **PDF**.
* Laporan Aset per Ruangan, Laporan Sisa Stok BHP, dan Laporan Peminjaman Aktif.

### 7. 🏗️ Peningkatan Arsitektur & Kualitas Kode (v2.0)
* **PHP Enums:** Menggantikan *magic strings* untuk status dan kondisi aset, meminimalisir *typo* dan meningkatkan keamanan tipe data.
* **Database Agnostic:** Menggunakan standar SQL universal (`CASE WHEN`) untuk sorting, memastikan kompatibilitas dengan MySQL, PostgreSQL, dan SQLite.
* **Fat Model, Skinny Controller:** Logika bisnis (validasi peminjaman) dipusatkan di Model, membuat Controller lebih bersih dan mudah dibaca.

---

## 🛠️ Teknologi yang Digunakan

* **Backend Framework:** Laravel 12
* **Language:** PHP 8.3
* **Database:** MySQL
* **Frontend:** Blade Templates + Tailwind CSS (Flowbite)
* **Authentication:** Laravel Breeze
* **PDF Generator:** Barryvdh DomPDF

---

## 📸 Tangkapan Layar (Screenshots)

| Dashboard | Peminjaman |
|:---:|:---:|
| ![Dashboard](https://placehold.co/600x400?text=Screenshot+Dashboard) | ![Peminjaman](https://placehold.co/600x400?text=Screenshot+Peminjaman) |

| Stok BHP | Laporan PDF |
|:---:|:---:|
| ![Stok](https://placehold.co/600x400?text=Screenshot+Stok+BHP) | ![Laporan](https://placehold.co/600x400?text=Screenshot+Laporan+PDF) |

---

## ⚙️ Instalasi & Pengaturan

Ikuti langkah ini untuk menjalankan proyek di komputer lokal:

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/username/sim-inventaris.git](https://github.com/username/sim-inventaris.git)
    cd sim-inventaris
    ```

2.  **Install Dependensi**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan database.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Setup Database**
    Pastikan database MySQL `sim_inventaris_db` sudah dibuat, lalu jalankan migrasi dan seeder.
    ```bash
    php artisan migrate:fresh --seed --seeder=UserSeeder
    php artisan db:seed --class=CategorySeeder
    php artisan db:seed --class=MasterDataSeeder
    ```

5.  **Jalankan Aplikasi**
    ```bash
    npm run dev
    # Buka terminal baru
    php artisan serve
    ```

---

## 🔐 Akun Demo

Gunakan akun berikut untuk masuk ke sistem:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@kampus.com` | `password` |
| **Staff Logistik** | `staff@kampus.com` | `password` |

---

## 👨‍💻 Pengembang

Dikembangkan sebagai Tugas Akhir / Proyek Mata Kuliah.

* **Nama:** M. Oriza saltifa
* **NIM:** 24210099
* **Kampus:** UBBG

---

> **Catatan:** Sistem ini dibuat dengan pendekatan *Clean Code* dan *Database Normalization* untuk memastikan integritas data jangka panjang.
