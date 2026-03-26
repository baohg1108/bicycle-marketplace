<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BikeModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'year_start',
        'year_end',
        'msrp',
        'description'
    ];

    protected $casts = [
        'year_start' => 'integer',
        'year_end' => 'integer',
        'msrp' => 'decimal:2',
    ];

    public function brand()
    {
        return $this->belongsTo(BikeBrand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(BikeCategory::class, 'category_id');
    }
    
    public function listings()
    {
        return $this->hasMany(Listing::class, 'model_id');
    }
}