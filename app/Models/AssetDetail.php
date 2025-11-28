<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetDetail extends Model
{
    use SoftDeletes; // Enable soft delete for disposal

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

    public function disposals()
    {
        return $this->hasMany(Disposal::class);
    }

    /**
     * Check if asset can be disposed
     */
    public function isDisposable(): bool
    {
        // Cannot dispose if borrowed
        if ($this->status === \App\Enums\AssetStatus::DIPINJAM->value) {
            return false;
        }

        // Cannot dispose if has pending mutation
        $hasPendingMutation = $this->mutations()
            ->where('status', \App\Enums\MutationStatus::PENDING->value)
            ->exists();

        return !$hasPendingMutation;
    }
}