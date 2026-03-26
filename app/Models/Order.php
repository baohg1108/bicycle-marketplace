<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'listing_id',
        'buyer_id',
        'seller_id',
        'amount',
        'deposit_amount',
        'status',
        'inspection_required',
        'notes',
        'cancelled_reason',
        'cancelled_by',
        'completed_at',
    ];

    protected $casts = [
        'inspection_required' => 'boolean',
        'completed_at' => 'datetime',
    ];


    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}