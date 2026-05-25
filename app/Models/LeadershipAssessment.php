<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadershipAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_name',
        'department',
        'line_manager',
        'comments',
        'signature_path',
        'overall_score',
        'status',
        'approval_status',
        'created_by',
    ];

    public function ratings()
    {
        return $this->hasMany(LeadershipCompetencyRating::class);
    }
}
