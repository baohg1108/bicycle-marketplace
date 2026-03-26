<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewResponse extends Model
{
    use HasFactory;

    protected $table = 'review_responses';

    public $timestamps = false;

    protected $fillable = [
        'review_id',
        'content',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}