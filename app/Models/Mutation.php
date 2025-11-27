<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Mutation extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'mutation_date' => 'date',
        'approved_at' => 'datetime',
        'status' => \App\Enums\MutationStatus::class,
        'asset_condition' => \App\Enums\AssetCondition::class,
    ];

    // ========================================
    // RELATIONSHIPS
    // ========================================

    public function asset()
    {
        return $this->belongsTo(AssetDetail::class, 'asset_id');
    }

    public function fromRoom()
    {
        return $this->belongsTo(Room::class, 'from_room_id');
    }

    public function toRoom()
    {
        return $this->belongsTo(Room::class, 'to_room_id');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ========================================
    // BUSINESS LOGIC METHODS
    // ========================================

    /**
     * Approve mutasi dan update room_id aset
     */
    public function approve($userId)
    {
        if ($this->status !== \App\Enums\MutationStatus::PENDING) {
            throw new \Exception('Hanya mutasi dengan status PENDING yang bisa di-approve.');
        }

        // Update status mutasi
        $this->update([
            'status' => \App\Enums\MutationStatus::COMPLETED,
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);

        // Update room_id di asset_details
        $this->asset->update([
            'room_id' => $this->to_room_id,
        ]);

        return true;
    }

    /**
     * Reject mutasi
     */
    public function reject($userId)
    {
        if ($this->status !== \App\Enums\MutationStatus::PENDING) {
            throw new \Exception('Hanya mutasi dengan status PENDING yang bisa di-reject.');
        }

        $this->update([
            'status' => \App\Enums\MutationStatus::REJECTED,
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);

        return true;
    }
}
