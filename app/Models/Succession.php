<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Succession extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_name',
        'department',
        'line_manager',
        'years_experience',
        'target_role',
        'core_competencies',
        'technical_competencies',
        'justification',
        'okr_achievement',
        'readiness_level',
        'ipg_score',
        'signature_path',
    ];
}
