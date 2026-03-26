<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListingComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'component_type',
        'brand',
        'model_name',
        'condition',
        'notes'
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}