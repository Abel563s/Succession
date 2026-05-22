<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_name',
        'mentee_name',
        'department',
        'period_covered',
        'achievements',
        'improvement_areas',
        'recommendations',
        'signature_path',
        'approval_status',
    ];
}
