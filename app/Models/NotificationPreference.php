<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $table = 'notification_preferences';

    public $timestamps = false;

    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'email_messages',
        'email_orders',
        'push_messages',
        'push_orders',
    ];

    protected $casts = [
        'email_messages' => 'boolean',
        'email_orders' => 'boolean',
        'push_messages' => 'boolean',
        'push_orders' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}