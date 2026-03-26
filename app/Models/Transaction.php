<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'user_id',
        'type',
        'amount',
        'fee',
        'net_amount',
        'payment_method',
        'status',
        'reference_code',
        'gateway_response',
        'created_at',
    ];

    protected $casts = [
        'gateway_response' => 'array',
        'created_at' => 'datetime',
    ];

  

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}