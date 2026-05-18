<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NineBoxGrid extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_name',
        'department',
        'grid_position',
        'potential_level',
        'performance_level',
        'general_comments',
        'strengths',
        'development_needs',
        'signature_path',
    ];
}
