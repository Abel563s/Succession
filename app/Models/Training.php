<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_name',
        'department',
        'line_manager',
        'goal_1',
        'skill_area_1',
        'score_1',
        'goal_2',
        'skill_area_2',
        'score_2',
        'goal_3',
        'skill_area_3',
        'score_3',
        'activities',
        'expected_outcomes',
        'feedback',
        'signature_path',
        'manager_signature',
        'candidate_signature',
    ];
}
