<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessHeartRate extends Model
{
    protected $table = 'user_profile_fitness_stats_heart_rate';
    protected $primaryKey = 'fitness_stats_hr_id';

    protected $fillable = [
        'workout_activity',
        'datasource',
        'bpm',
        'date',
        'time',
        'user_profiles_user_profile_id',
        'exercises_exercise_id',
    ];
}
