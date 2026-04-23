<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
    protected $table = 'training_programs';

    protected $fillable = [
        'program_ref_code',
        'program_title',
        'program_description',
        'program_duration',
        'program_category',
        'program_privacy',
        'created_by',
        'xp_points',
        'active',
        'creation_date',
    ];

    public function subscribers()
    {
        return $this->hasMany(ProgramSubscriber::class, 'program_ref_code', 'program_ref_code');
    }
}
