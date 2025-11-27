<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssetDetail;
use App\Models\ConsumableDetail;

class Room extends Model
{
    protected $guarded = ['id'];

    // Satu Ruangan milik satu Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // --- TAMBAHAN BARU UNTUK REKTOR ---

    // 1. Relasi ke Aset Tetap (Laptop, Meja, dll)
    public function assets()
    {
        return $this->hasMany(AssetDetail::class);
    }

    // 2. Relasi ke BHP (Stok Obat/ATK di ruangan itu)
    public function consumables()
    {
        return $this->hasMany(ConsumableDetail::class);
    }

    // 3. Relasi ke Mutasi (Perpindahan Aset)
    public function mutationsFrom()
    {
        return $this->hasMany(Mutation::class, 'from_room_id');
    }

    public function mutationsTo()
    {
        return $this->hasMany(Mutation::class, 'to_room_id');
    }
}
