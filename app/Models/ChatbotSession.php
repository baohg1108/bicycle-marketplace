<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatbotSession extends Model
{
    use HasFactory;

    protected $table = 'chatbot_sessions';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'session_token',
        'context_json',
        'last_active_at',
        'created_at',
    ];

    protected $casts = [
        'context_json' => 'array',
        'last_active_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function messages()
{
    return $this->hasMany(ChatbotMessage::class, 'session_id');
}
}