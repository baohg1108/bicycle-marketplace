<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogisticsProvider extends Model
{
    use HasFactory;

    protected $table = 'logistics_providers';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'api_base_url',
        'is_active',
        'config_json',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'config_json' => 'array',
    ];
}