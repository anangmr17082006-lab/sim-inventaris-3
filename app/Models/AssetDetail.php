<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetDetail extends Model
{
    protected $guarded = ['id'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function fundingSource()
    {
        return $this->belongsTo(FundingSource::class);
    }
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function isBorrowable(): bool
    {
        return $this->status === \App\Enums\AssetStatus::TERSEDIA->value &&
            $this->condition !== \App\Enums\AssetCondition::RUSAK_BERAT->value;
    }

    public function mutations()
    {
        return $this->hasMany(Mutation::class, 'asset_id');
    }
}