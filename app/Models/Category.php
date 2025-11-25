<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // PENTING: Untuk logika pencocokan string di getThemeAttribute

// Import Model Relasi
use App\Models\Inventory;
use App\Models\AssetDetail;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description'];

    /*
    |--------------------------------------------------------------------------
    | RELASI DATABASE
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Barang Induk (Inventory)
     * Satu Kategori -> Banyak Jenis Barang
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Relasi ke Unit Fisik (AssetDetail)
     * Satu Kategori -> Banyak Unit Fisik (melewati Inventory)
     * Memungkinkan kita menghitung total aset fisik: $category->assets()->count()
     */
    public function assets()
    {
        return $this->hasManyThrough(
            AssetDetail::class, // Tujuan akhir (Unit Fisik)
            Inventory::class,   // Perantara (Barang Induk)
            'category_id',      // FK di tabel inventories
            'inventory_id',     // FK di tabel asset_details
            'id',               // Local key di tabel categories
            'id'                // Local key di tabel inventories
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (PRESENTASI)
    |--------------------------------------------------------------------------
    */

    /**
     * Mengambil konfigurasi tema (warna, icon, style) berdasarkan nama kategori.
     * Penggunaan di Blade: $category->theme->classes['bg_soft'] atau $category->theme->icon
     * * @return object
     */
    public function getThemeAttribute()
    {
        $name = strtolower($this->name);

        // Definisi tema dengan class lengkap agar aman untuk Tailwind JIT Compiler.
        // Jangan dipecah-pecah string-nya.
        $themes = [
            'it' => [
                'keys' => ['elektronik', 'laptop', 'komputer', 'pc', 'server', 'monitor', 'keyboard', 'mouse'],
                'classes' => [
                    'bg_soft' => 'bg-blue-50',
                    'bg_hover' => 'group-hover:bg-blue-100',
                    'text' => 'text-blue-600',
                    'ring' => 'ring-blue-100/50',
                    'blob' => 'bg-blue-50',
                    'blob_hover' => 'group-hover:bg-blue-100',
                    'line_from' => 'from-blue-500',
                    'line_to' => 'to-blue-400',
                    'text_hover' => 'group-hover:text-blue-600',
                    'arrow_hover' => 'group-hover:text-blue-500',
                ],
                'icon' => 'computer-desktop'
            ],
            'print' => [
                'keys' => ['printer', 'scanner', 'fotocopy', 'cetak', 'tinta'],
                'classes' => [
                    'bg_soft' => 'bg-cyan-50',
                    'bg_hover' => 'group-hover:bg-cyan-100',
                    'text' => 'text-cyan-600',
                    'ring' => 'ring-cyan-100/50',
                    'blob' => 'bg-cyan-50',
                    'blob_hover' => 'group-hover:bg-cyan-100',
                    'line_from' => 'from-cyan-500',
                    'line_to' => 'to-cyan-400',
                    'text_hover' => 'group-hover:text-cyan-600',
                    'arrow_hover' => 'group-hover:text-cyan-500',
                ],
                'icon' => 'printer'
            ],
            'furn' => [
                'keys' => ['meubel', 'kursi', 'meja', 'lemari', 'furniture', 'rak', 'sofa'],
                'classes' => [
                    'bg_soft' => 'bg-amber-50',
                    'bg_hover' => 'group-hover:bg-amber-100',
                    'text' => 'text-amber-600',
                    'ring' => 'ring-amber-100/50',
                    'blob' => 'bg-amber-50',
                    'blob_hover' => 'group-hover:bg-amber-100',
                    'line_from' => 'from-amber-500',
                    'line_to' => 'to-amber-400',
                    'text_hover' => 'group-hover:text-amber-600',
                    'arrow_hover' => 'group-hover:text-amber-500',
                ],
                'icon' => 'home' // atau chair jika ada
            ],
            'vehicle' => [
                'keys' => ['kendaraan', 'mobil', 'motor', 'truk', 'transportasi', 'bus', 'sepeda'],
                'classes' => [
                    'bg_soft' => 'bg-rose-50',
                    'bg_hover' => 'group-hover:bg-rose-100',
                    'text' => 'text-rose-600',
                    'ring' => 'ring-rose-100/50',
                    'blob' => 'bg-rose-50',
                    'blob_hover' => 'group-hover:bg-rose-100',
                    'line_from' => 'from-rose-500',
                    'line_to' => 'to-rose-400',
                    'text_hover' => 'group-hover:text-rose-600',
                    'arrow_hover' => 'group-hover:text-rose-500',
                ],
                'icon' => 'truck'
            ],
            'build' => [
                'keys' => ['gedung', 'bangunan', 'ruangan', 'tanah', 'kelas', 'gudang'],
                'classes' => [
                    'bg_soft' => 'bg-emerald-50',
                    'bg_hover' => 'group-hover:bg-emerald-100',
                    'text' => 'text-emerald-600',
                    'ring' => 'ring-emerald-100/50',
                    'blob' => 'bg-emerald-50',
                    'blob_hover' => 'group-hover:bg-emerald-100',
                    'line_from' => 'from-emerald-500',
                    'line_to' => 'to-emerald-400',
                    'text_hover' => 'group-hover:text-emerald-600',
                    'arrow_hover' => 'group-hover:text-emerald-500',
                ],
                'icon' => 'building-office'
            ],
            'tool' => [
                'keys' => ['mesin', 'alat', 'peralatan', 'teknis', 'obeng', 'bor', 'palu'],
                'classes' => [
                    'bg_soft' => 'bg-slate-50',
                    'bg_hover' => 'group-hover:bg-slate-100',
                    'text' => 'text-slate-600',
                    'ring' => 'ring-slate-100/50',
                    'blob' => 'bg-slate-50',
                    'blob_hover' => 'group-hover:bg-slate-100',
                    'line_from' => 'from-slate-500',
                    'line_to' => 'to-slate-400',
                    'text_hover' => 'group-hover:text-slate-600',
                    'arrow_hover' => 'group-hover:text-slate-500',
                ],
                'icon' => 'wrench'
            ],
            'doc' => [
                'keys' => ['atk', 'tulis', 'kertas', 'buku', 'dokumen', 'arsip', 'map'],
                'classes' => [
                    'bg_soft' => 'bg-violet-50',
                    'bg_hover' => 'group-hover:bg-violet-100',
                    'text' => 'text-violet-600',
                    'ring' => 'ring-violet-100/50',
                    'blob' => 'bg-violet-50',
                    'blob_hover' => 'group-hover:bg-violet-100',
                    'line_from' => 'from-violet-500',
                    'line_to' => 'to-violet-400',
                    'text_hover' => 'group-hover:text-violet-600',
                    'arrow_hover' => 'group-hover:text-violet-500',
                ],
                'icon' => 'document-text'
            ],
            'clean' => [
                'keys' => ['bersih', 'sapu', 'pel', 'sampah', 'kebersihan'],
                'classes' => [
                    'bg_soft' => 'bg-teal-50',
                    'bg_hover' => 'group-hover:bg-teal-100',
                    'text' => 'text-teal-600',
                    'ring' => 'ring-teal-100/50',
                    'blob' => 'bg-teal-50',
                    'blob_hover' => 'group-hover:bg-teal-100',
                    'line_from' => 'from-teal-500',
                    'line_to' => 'to-teal-400',
                    'text_hover' => 'group-hover:text-teal-600',
                    'arrow_hover' => 'group-hover:text-teal-500',
                ],
                'icon' => 'sparkles'
            ],
        ];

        // Default Theme (Indigo - Fallback jika tidak ada keyword yang cocok)
        $selectedTheme = [
            'classes' => [
                'bg_soft' => 'bg-indigo-50',
                'bg_hover' => 'group-hover:bg-indigo-100',
                'text' => 'text-indigo-600',
                'ring' => 'ring-indigo-100/50',
                'blob' => 'bg-indigo-50',
                'blob_hover' => 'group-hover:bg-indigo-100',
                'line_from' => 'from-indigo-500',
                'line_to' => 'to-indigo-400',
                'text_hover' => 'group-hover:text-indigo-600',
                'arrow_hover' => 'group-hover:text-indigo-500',
            ],
            'icon' => 'archive-box'
        ];

        // Logic Pencocokan
        foreach ($themes as $theme) {
            if (Str::contains($name, $theme['keys'])) {
                $selectedTheme = $theme;
                break;
            }
        }

        // Return sebagai object agar bisa diakses dengan sintaks panah (->)
        return (object) $selectedTheme;
    }
}