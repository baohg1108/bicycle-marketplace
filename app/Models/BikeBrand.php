<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BikeBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'country_origin',
        'logo_url',
        'website_url',
        'description',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function models()
    {
        return $this->hasMany(BikeModel::class, 'brand_id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'brand_id');
    }
}