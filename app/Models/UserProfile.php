<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false; 
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'bio',
        'city',
        'district',
        'id_number',
        'is_verified',
        'rating_score',
        'rating_count',
        'total_sold',
        'total_bought',
        'response_rate'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'rating_score' => 'decimal:2',
        'rating_count' => 'integer',
        'total_sold' => 'integer',
        'total_bought' => 'integer',
        'response_rate' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}