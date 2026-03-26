<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InspectionRequest extends Model
{
    use HasFactory;

    protected $table = 'inspection_requests';

    public $timestamps = false;

    protected $fillable = [
        'listing_id',
        'order_id',
        'requester_id',
        'inspector_id',
        'type',
        'status',
        'inspection_fee',
        'scheduled_at',
        'location',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'inspection_fee' => 'float',
        'scheduled_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
    public function report()
{
    return $this->hasOne(InspectionReport::class, 'request_id');
}
}