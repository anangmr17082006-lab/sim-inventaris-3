<?php

namespace App\Models;

use App\Enums\DisposalStatus;
use App\Enums\DisposalType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Disposal extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'disposal_type' => DisposalType::class,
        'status' => DisposalStatus::class,
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function assetDetail()
    {
        return $this->belongsTo(AssetDetail::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Query Scopes
    public function scopePending($query)
    {
        return $query->where('status', DisposalStatus::PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', DisposalStatus::APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', DisposalStatus::REJECTED);
    }

    // Business Logic Methods

    /**
     * Check if disposal can be approved
     */
    public function canBeApproved(): bool
    {
        // Must be pending
        if ($this->status !== DisposalStatus::PENDING) {
            return false;
        }

        // Asset must still exist and not already disposed
        if (!$this->assetDetail || $this->assetDetail->trashed()) {
            return false;
        }

        // Asset cannot be borrowed
        if ($this->assetDetail->status === \App\Enums\AssetStatus::DIPINJAM->value) {
            return false;
        }

        // Asset cannot have pending mutations
        $hasPendingMutation = $this->assetDetail->mutations()
            ->where('status', \App\Enums\MutationStatus::PENDING->value)
            ->exists();

        return !$hasPendingMutation;
    }

    /**
     * Approve disposal request and soft delete the asset
     */
    public function approve(User $admin, ?string $notes = null): bool
    {
        if (!$this->canBeApproved()) {
            return false;
        }

        return DB::transaction(function () use ($admin, $notes) {
            // Update disposal record
            $this->update([
                'status' => DisposalStatus::APPROVED,
                'reviewed_by' => $admin->id,
                'approved_at' => now(),
                'notes' => $notes,
                'book_value' => $this->assetDetail->price, // Capture current price
            ]);

            // Soft delete the asset
            $this->assetDetail->delete();

            return true;
        });
    }

    /**
     * Reject disposal request
     */
    public function reject(User $admin, string $reason): bool
    {
        if ($this->status !== DisposalStatus::PENDING) {
            return false;
        }

        $this->update([
            'status' => DisposalStatus::REJECTED,
            'reviewed_by' => $admin->id,
            'approved_at' => now(),
            'notes' => $reason,
        ]);

        return true;
    }
}
