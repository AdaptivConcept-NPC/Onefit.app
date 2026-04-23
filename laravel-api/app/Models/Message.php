<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'user_conversation_messages';
    protected $primaryKey = 'message_id';

    protected $fillable = [
        'conversation_id',
        'message',
        'send_date',
        'message_read',
        'message_deleted',
        'sender',
        'receiver',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'conversation_id');
    }
}
