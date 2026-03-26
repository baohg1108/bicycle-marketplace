<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'type',
        'metadata_json',
        'read_at'
    ];

    protected $casts = [
        'metadata_json' => 'array',
        'read_at' => 'datetime',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }


    public function isRead()
    {
        return !is_null($this->read_at);
    }
}