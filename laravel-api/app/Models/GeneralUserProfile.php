<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralUserProfile extends Model
{
    protected $table = 'general_user_profiles';
    protected $primaryKey = 'user_profile_id';

    protected $fillable = [
        'users_username',
        'about',
        'profile_type',
        'profile_url',
        'verification',
        'profile_banner_url',
        'profile_image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_username', 'username');
    }

    public function aboutInfo()
    {
        return $this->hasOne(UserProfileAbout::class, 'general_user_profiles_user_profile_id', 'user_profile_id');
    }
}
