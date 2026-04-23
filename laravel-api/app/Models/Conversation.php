<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'user_conversations';
    protected $primaryKey = 'conversation_id';

    protected $fillable = [
        'conversation_start_date',
        'primary_user',
        'secondary_user',
        'conversations_reference',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'conversation_id');
    }
}
