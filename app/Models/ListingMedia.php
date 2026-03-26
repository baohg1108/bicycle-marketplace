<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListingMedia extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'listing_id',
        'url',
        'thumb_url',
        'type',
        'sort_order',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}