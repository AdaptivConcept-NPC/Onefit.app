<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessStepCount extends Model
{
    protected $table = 'user_profile_fitness_stats_step_count';
    protected $primaryKey = 'fitness_stats_steps_id';

    protected $fillable = [
        'workout_activity',
        'datasource',
        'steps',
        'date',
        'time',
        'user_profiles_user_profile_id',
        'exercises_exercise_id',
    ];
}
