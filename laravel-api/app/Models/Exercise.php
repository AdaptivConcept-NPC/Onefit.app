<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercises';
    protected $primaryKey = 'exercise_id';

    protected $fillable = [
        'exercise_name',
        'exercise_description',
        'exercise_type',
        'exercise_category',
        'exercise_difficulty',
        'muscle_group',
        'xp_points',
        'created_by',
    ];
}
