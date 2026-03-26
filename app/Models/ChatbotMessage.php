<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatbotMessage extends Model
{
    use HasFactory;

    protected $table = 'chatbot_messages';

    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'role',
        'content',
        'intent',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(ChatbotSession::class, 'session_id');
    }
}