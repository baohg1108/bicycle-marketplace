<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'reviewer_id',
        'reviewee_id',
        'listing_id',
        'rating',
        'comment',
        'is_buyer_review',
        'created_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_buyer_review' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
    public function response()
{
    return $this->hasOne(ReviewResponse::class);
}
}