# Feedback & Rencana Peningkatan Sistem Inventaris

Dokumen ini berisi detail teknis mengenai saran peningkatan untuk membuat kode lebih *maintainable*, *robust*, dan sesuai dengan standar industri (Enterprise Level).

---

## 1. Gunakan PHP Enums untuk Status (Anti "Magic Strings")

**Masalah:**
Penggunaan string manual (hardcoded) seperti `'tersedia'`, `'rusak_berat'`, `'dipinjam'` rentan terhadap *typo* (kesalahan penulisan) yang sulit dideteksi.

**Solusi:**
Gunakan fitur **Enum** (tersedia di PHP 8.1+) untuk menstandarisasi nilai-nilai status.

### Before (Saat Ini)
```php
// LoanController.php
$q->where('status', 'tersedia')->where('condition', 'baik');
```

### After (Rekomendasi)
Buat file `app/Enums/AssetStatus.php`:
```php
namespace App\Enums;

enum AssetStatus: string {
    case TERSEDIA = 'tersedia';
    case DIPINJAM = 'dipinjam';
    case RUSAK = 'rusak';
    case HILANG = 'hilang';
}
```

Implementasi di Controller:
```php
use App\Enums\AssetStatus;

$q->where('status', AssetStatus::TERSEDIA->value);
```

---

## 2. Database Agnostic (Hindari Fungsi Spesifik MySQL)

**Masalah:**
Kode saat ini menggunakan fungsi `FIELD()` untuk sorting kustom.
```php
orderByRaw("FIELD(status, 'dipinjam', 'telat', 'kembali')")
```
Fungsi ini **hanya berjalan di MySQL**. Jika aplikasi dipindah ke PostgreSQL atau ditest menggunakan SQLite (untuk automated testing yang cepat), fitur ini akan error.

**Solusi:**
Gunakan logika sorting berbasis integer atau `CASE WHEN` yang lebih universal, atau biarkan sorting dilakukan di level Collection jika datanya sedikit (kurang disarankan untuk data besar).

### After (Rekomendasi - SQL Standard)
```php
orderByRaw("CASE 
    WHEN status = 'dipinjam' THEN 1 
    WHEN status = 'telat' THEN 2 
    WHEN status = 'kembali' THEN 3 
    ELSE 4 
END")
```

---

## 3. Fat Model, Skinny Controller (Pindahkan Logika Bisnis)

**Masalah:**
Controller saat ini menangani logika pengecekan kondisi fisik barang. Ini membuat controller "gemuk" dan logika sulit digunakan ulang di tempat lain.

### Before (Saat Ini)
```php
// LoanController.php
if ($asset->condition == 'rusak_berat') {
    return back()->withErrors(['msg' => 'Gagal! Barang rusak berat tidak boleh dipinjam.']);
}
```

### After (Rekomendasi)
Pindahkan logika "apakah barang boleh dipinjam?" ke dalam Model `AssetDetail`.

**Di Model (`App\Models\AssetDetail.php`):**
```php
public function isBorrowable(): bool
{
    return $this->status === 'tersedia' && $this->condition !== 'rusak_berat';
}
```

**Di Controller:**
```php
if (!$asset->isBorrowable()) {
    return back()->withErrors(['msg' => 'Barang tidak memenuhi syarat untuk dipinjam.']);
}
```
**Keuntungan:** Kode controller menjadi sangat mudah dibaca seperti bahasa manusia, dan logika validasi terpusat di satu tempat.
