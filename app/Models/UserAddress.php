<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'full_address',
        'city',
        'district',
        'ward',
        'lat',
        'lng',
        'is_default'
    ];

    protected $casts = [
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressFormattedAttribute()
    {
        return implode(', ', array_filter([
            $this->full_address,
            $this->ward,
            $this->district,
            $this->city
        ]));
    }
}