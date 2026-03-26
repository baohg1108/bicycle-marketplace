<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentGatewayLog extends Model
{
    use HasFactory;

    protected $table = 'payment_gateway_logs';

    public $timestamps = false;

    protected $fillable = [
        'transaction_id',
        'gateway_id',
        'gateway_ref',
        'request_json',
        'response_json',
        'status',
        'created_at',
    ];

    protected $casts = [
        'request_json' => 'array',
        'response_json' => 'array',
        'created_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway_id');
    }
}