<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceFeeConfig extends Model
{
    protected $fillable = [
        'name',
        'type',
        'value',
        'applicable_to',
        'min_amount',
        'max_amount',
        'is_active',
        'effective_from',
        'effective_to',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'effective_from' => 'date',
        'effective_to' => 'date',
    ];
}