<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    protected $table = 'user_socials';
    protected $primaryKey = 'user_social_id';

    protected $fillable = [
        'social_network',
        'handle',
        'link',
        'username',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
