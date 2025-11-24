# Penjelasan Perbaikan Sistem Inventaris

Dokumen ini menjelaskan detail teknis dari perbaikan yang telah dilakukan pada kode sumber aplikasi Sim Inventaris untuk meningkatkan kualitas, keamanan, dan keterbacaan kode (*maintainability*).

---

## 1. Penggunaan PHP Enums (Anti "Magic Strings")

**Masalah Sebelumnya:**
Kode menggunakan string manual (hardcoded) seperti `'tersedia'`, `'rusak_berat'`, `'dipinjam'`. Hal ini rentan terhadap kesalahan penulisan (*typo*) dan sulit untuk dikelola jika ada perubahan nama status di masa depan.

**Perbaikan:**
Kami telah mengimplementasikan fitur **PHP Enums** (tersedia di PHP 8.1+) untuk menstandarisasi nilai-nilai status.

**File Baru:**
- `app/Enums/AssetStatus.php`: Menyimpan status aset (`TERSEDIA`, `DIPINJAM`, `RUSAK`, `HILANG`).
- `app/Enums/AssetCondition.php`: Menyimpan kondisi aset (`BAIK`, `RUSAK_RINGAN`, `RUSAK_BERAT`).
- `app/Enums/LoanStatus.php`: Menyimpan status peminjaman (`DIPINJAM`, `TELAT`, `KEMBALI`).

**Contoh Perubahan Code:**
*Sebelum:*
```php
$q->where('status', 'tersedia');
```
*Sesudah:*
```php
use App\Enums\AssetStatus;
$q->where('status', AssetStatus::TERSEDIA->value);
```

---

## 2. Database Agnostic Sorting (Standar SQL Universal)

**Masalah Sebelumnya:**
Kode menggunakan fungsi `FIELD()` untuk melakukan kustomisasi urutan data (`orderByRaw("FIELD(status, 'dipinjam', 'telat', 'kembali')")`). Fungsi `FIELD()` adalah fitur spesifik **MySQL** dan tidak akan berjalan jika aplikasi dipindahkan ke database lain seperti PostgreSQL atau SQLite.

**Perbaikan:**
Kami menggantinya dengan sintaks `CASE WHEN` yang merupakan standar SQL universal.

**Implementasi di `LoanController.php`:**
```php
->orderByRaw("CASE 
    WHEN status = '" . LoanStatus::DIPINJAM->value . "' THEN 1 
    WHEN status = '" . LoanStatus::TELAT->value . "' THEN 2 
    WHEN status = '" . LoanStatus::KEMBALI->value . "' THEN 3 
    ELSE 4 
 END")
```

---

## 3. Refactoring Logika Bisnis (Fat Model, Skinny Controller)

**Masalah Sebelumnya:**
Controller (`LoanController`) menangani terlalu banyak logika pengecekan, seperti memeriksa apakah barang rusak berat atau sedang dipinjam. Ini membuat controller menjadi "gemuk" dan logika tersebut sulit digunakan ulang di tempat lain.

**Perbaikan:**
Kami memindahkan logika validasi "apakah barang boleh dipinjam?" ke dalam Model `AssetDetail`.

**Di Model (`app/Models/AssetDetail.php`):**
Kami menambahkan method `isBorrowable()`:
```php
public function isBorrowable(): bool
{
    return $this->status === \App\Enums\AssetStatus::TERSEDIA->value && 
           $this->condition !== \App\Enums\AssetCondition::RUSAK_BERAT->value;
}
```

**Di Controller (`app/Http/Controllers/LoanController.php`):**
Kode menjadi lebih bersih dan mudah dibaca seperti bahasa manusia:
```php
if (!$asset->isBorrowable()) {
    return back()->withErrors(['msg' => 'Barang tidak memenuhi syarat...']);
}
```

---

## Kesimpulan Manfaat

1.  **Lebih Aman dari Typo**: Menggunakan Enum mencegah kesalahan ketik string status.
2.  **Kompatibilitas Database**: Kode sekarang bisa berjalan di berbagai jenis database (MySQL, PostgreSQL, SQLite).
3.  **Kode Lebih Bersih**: Controller lebih fokus pada alur aplikasi, sementara logika bisnis yang kompleks disembunyikan di dalam Model.
4.  **Mudah Dirawat**: Jika ada perubahan aturan bisnis (misal: barang rusak ringan juga tidak boleh dipinjam), kita hanya perlu mengubahnya di satu tempat (Model), dan semua bagian aplikasi akan otomatis mengikuti.
