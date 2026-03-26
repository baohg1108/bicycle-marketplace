<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InspectionLabel extends Model
{
    use HasFactory;

    protected $table = 'inspection_labels';

    public $timestamps = false;

    protected $fillable = [
        'listing_id',
        'report_id',
        'inspector_id',
        'label_type',
        'issued_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function report()
    {
        return $this->belongsTo(InspectionReport::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}