<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListingSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'spec_key',
        'spec_value'
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}