<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessBmi extends Model
{
    protected $table = 'user_profile_fitness_stats_bmi';
    protected $primaryKey = 'fitness_stats_bmi_id';

    protected $fillable = [
        'workout_activity',
        'datasource',
        'bmi',
        'bmi_status',
        'weight',
        'date',
        'time',
        'user_profiles_user_profile_id',
        'exercises_exercise_id',
    ];

    public function profile()
    {
        return $this->belongsTo(GeneralUserProfile::class, 'user_profiles_user_profile_id', 'user_profile_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercises_exercise_id', 'exercise_id');
    }
}
