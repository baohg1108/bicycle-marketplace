<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListingReport extends Model
{
    use HasFactory;

    protected $table = 'listing_reports';

    public $timestamps = false;

    protected $fillable = [
        'listing_id',
        'reporter_id',
        'reason',
        'description',
        'status',
        'resolved_by',
        'resolved_at',
        'resolution_note',
        'created_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}