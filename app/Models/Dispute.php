<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dispute extends Model
{
    use HasFactory;

    protected $table = 'disputes';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'initiator_id',
        'reason',
        'description',
        'evidence_json',
        'status',
        'assigned_inspector',
        'resolution',
        'resolution_note',
        'resolved_at',
        'created_at',
    ];

    protected $casts = [
        'evidence_json' => 'array',
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'assigned_inspector');
    }
}