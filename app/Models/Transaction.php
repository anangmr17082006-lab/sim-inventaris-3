<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];

    public function detail()
    {
        return $this->belongsTo(ConsumableDetail::class, 'consumable_detail_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Query scope for disposal transactions
    public function scopeDisposals($query)
    {
        return $query->where('transaction_category', 'disposal');
    }
}