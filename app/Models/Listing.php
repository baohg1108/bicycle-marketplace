<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'brand_id',
        'model_id',
        'title',
        'description',
        'price',
        'negotiable',
        'condition',
        'status',
        'frame_size',
        'wheel_size',
        'frame_material',
        'color',
        'manufacture_year',
        'mileage_km',
        'city',
        'district',
        'lat',
        'lng',
        'view_count',
        'is_featured',
        'is_inspected',
        'expires_at',
        'published_at'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'negotiable' => 'boolean',
        'is_featured' => 'boolean',
        'is_inspected' => 'boolean',
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'manufacture_year' => 'integer',
        'expires_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(BikeCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(BikeBrand::class);
    }

    public function model()
    {
        return $this->belongsTo(BikeModel::class);
    }

    public function media()
    {
        return $this->hasMany(ListingMedia::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ListingMedia::class)->where('is_primary', true);
    }

    public function components()
    {
        return $this->hasMany(ListingComponent::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'listing_tags');
    }

    public function specs()
{
    return $this->hasMany(ListingSpec::class);
}

public function wishlistedBy()
{
    return $this->belongsToMany(User::class, 'wishlists')
        ->withTimestamps();
}


    public function getLocationAttribute()
    {
        return "{$this->district}, {$this->city}";
    }
}