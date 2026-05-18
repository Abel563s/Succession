<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    ];

    public function ratings()
    {
        return $this->hasMany(LeadershipCompetencyRating::class);
    }
}
