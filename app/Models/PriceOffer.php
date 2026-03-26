<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceOffer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'message_id',
        'conversation_id',
        'amount',
        'status',
        'counter_amount',
        'expires_at',
        'responded_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'responded_at' => 'datetime',
    ];


    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}