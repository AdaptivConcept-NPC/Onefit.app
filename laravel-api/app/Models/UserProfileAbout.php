<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfileAbout extends Model
{
    protected $table = 'user_profile_about';

    protected $fillable = [
        'general_user_profiles_user_profile_id',
        'height',
        'target_weight',
        'fitness_goals',
        'preferred_workout_time',
    ];

    public function profile()
    {
        return $this->belongsTo(GeneralUserProfile::class, 'general_user_profiles_user_profile_id', 'user_profile_id');
    }
}
