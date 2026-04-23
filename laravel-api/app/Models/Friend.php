<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';
    protected $primaryKey = 'friend_id';

    protected $fillable = [
        'users_username',
        'friends_username',
        'friend_status',
        'friend_request_date',
        'friend_accept_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_username', 'username');
    }

    public function friendUser()
    {
        return $this->belongsTo(User::class, 'friends_username', 'username');
    }
}
