<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

    protected $table = 'shipments';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'provider_id',
        'tracking_number',
        'status',
        'shipping_fee',
        'sender_address_id',
        'receiver_address_id',
        'estimated_delivery',
        'delivered_at',
        'provider_response',
        'created_at',
    ];

    protected $casts = [
        'shipping_fee' => 'float',
        'estimated_delivery' => 'date',
        'delivered_at' => 'datetime',
        'provider_response' => 'array',
        'created_at' => 'datetime',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function provider()
    {
        return $this->belongsTo(LogisticsProvider::class, 'provider_id');
    }

    public function senderAddress()
    {
        return $this->belongsTo(UserAddress::class, 'sender_address_id');
    }

    public function receiverAddress()
    {
        return $this->belongsTo(UserAddress::class, 'receiver_address_id');
    }
}